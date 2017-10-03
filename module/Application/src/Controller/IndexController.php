<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Categories;
use Application\Entity\Words;
use Doctrine\ORM\EntityManager;
use User\Entity\User;
use Application\Entity\Game;


/**
 * This is the main controller class of the User Demo application. It contains
 * site-wide actions such as Home or About.
 */
class IndexController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Session manager.
     * @var Zend\Session\SessionContainer
     */
    private $sessionContainer;

    /**
     * Game manager.
     * @var \Application\Service\GameManager
     */
    private $gameManager;
    
    /**
     * Constructor. Its purpose is to inject dependencies into the controller.
     */
    public function __construct($entityManager,$sessionContainer, $gameManager)
    {
        $this->entityManager = $entityManager;
        $this->sessionContainer  = $sessionContainer;
        $this->gameManager = $gameManager;
    }

    public function indexAction()
    {
        $categories =  $this->entityManager ->getRepository(Categories::class)->findAll();

        return array('categories' => $categories);
    }

    public function playAction() {

        $id = $this->params()->fromRoute('id', -1);
        if ($id) {

            $allWords = $this->entityManager ->getRepository(Categories::class)->find($id);
            if ($allWords) {
                $allWords->getWords();

                $allWordsArray = array();
                /** @var  $word \Application\Entity\Words */
                foreach ($allWords->getWords() as $word) {
                    array_push($allWordsArray, array( 'id'          =>$word->getId(),
                        'word'        =>$word->getWord(),
                        'description' =>$word->getDescription() ));
                }

                $key = array_rand($allWordsArray, 1);
                $selectedWord = $allWordsArray[$key];

                $currentWordArray = array();
                $currentWord = explode(' ', $selectedWord['word']);
                $preparedWordArray = array();
                $checkInnerLettersArray = array();

                //Save used letters in session
                $this->sessionContainer->usedLetters = array();

                foreach ($currentWord as $parts) {
                    //Make an array of all letters
                    $wordArray =  preg_split('//u', mb_strtolower($parts), -1, PREG_SPLIT_NO_EMPTY);

                    //prepare the part for playing
                    //the word is in cyrlic
                    $firstLetter = mb_substr($parts,0,1);
                    array_push($currentWordArray, mb_strtolower($firstLetter));
                    array_push($this->sessionContainer->usedLetters, mb_strtolower($firstLetter));
                    if (empty(array_keys($checkInnerLettersArray, mb_strtolower($firstLetter)))) {
                        array_push($checkInnerLettersArray, mb_strtolower($firstLetter));
                    }
                    array_push($preparedWordArray,$firstLetter);

                    for ($i=1; $i<= (mb_strlen($parts)-2); $i++){
                        array_push($preparedWordArray, "_");
                        array_push($currentWordArray, $wordArray[$i]);

                    }

                    $lastLetter = mb_substr($parts,-1);
                    array_push($preparedWordArray, $lastLetter);
                    if (empty(array_keys($checkInnerLettersArray, mb_strtolower($lastLetter)))) {
                        array_push($checkInnerLettersArray, mb_strtolower($lastLetter));
                    }
                    array_push($currentWordArray,mb_strtolower($lastLetter));
                    array_push($this->sessionContainer->usedLetters, mb_strtolower($lastLetter));
                }

                //Check for occurences for first and last letters
                foreach ($checkInnerLettersArray as $letter) {
                    $occurences = array_keys($currentWordArray, $letter);
                    if (!empty($occurences)) {
                        foreach ($occurences as $key) {
                            //Change only inner letters
                            if ($preparedWordArray[$key] == "_") {
                                $preparedWordArray[$key] = $letter;
                            }
                        }
                    }
                }

                //Count the letters to fill
                $numLettersToFill = 0;
                foreach ($preparedWordArray as $symbol) {
                    if ($symbol == '_') {
                        $numLettersToFill += 1;
                    }
                }

                $user = $this->entityManager->getRepository(User::class)
                    ->findOneByEmail($this->identity());
                $data['user'] = $user;
                $data['word'] = $this->entityManager->getRepository(Words::class)
                    ->find($selectedWord['id']);
                $data['letterNum'] = $numLettersToFill;
                $game = $this->gameManager->addGame($data);

                //Save the game into the session
                $this->sessionContainer->gameId = $game->getId();
                //Save the word in array format into the session
                $this->sessionContainer->selectedWordArray = $currentWordArray;
                //Save the whole word in session
                $this->sessionContainer->selectedWord = $selectedWord;
                //Set the error counter to 0
                $this->sessionContainer->errors = 0;
                return(array('selectedWord' => $selectedWord, 'preparedWordArray' => $preparedWordArray, 'usedLetters' => implode(',', $this->sessionContainer->usedLetters)));

            } else {
                $this->flashmessenger()->addErrorMessage("Не сте избрали Категория");
                return $this->redirect()->toRoute('home');
            }
        }

    }

    public function checkletterAction(){
        $request = $this->getRequest();
        $response = $this->getResponse();

        $post = $request->getPost();
        if ($post['letter']) {
            if(isset($this->sessionContainer->selectedWordArray)) {
                $selectedWordArray = $this->sessionContainer->selectedWordArray;
                $letter = $post['letter'];
                $usedLetters = $this->sessionContainer->usedLetters;

                //If lettes is not used
                if (!in_array($letter,$usedLetters)) {
                    array_push($this->sessionContainer->usedLetters,$letter);
                    $occurences = array_keys($selectedWordArray, $letter);
                    if (count($occurences) > 0) {
                        $gameID = $this->sessionContainer->gameId;
                        $game = $this->entityManager->getRepository(Game::class)->find($gameID);
                        $this->gameManager->updateCurrentGamePositive($game,count($occurences));
                    }
                }  else {
                    $occurences = '';
                }

                $result = array('exist' => $occurences, 'letters'=>$this->sessionContainer->usedLetters);

                $vm = new ViewModel();
                $vm->setTerminal(true);
                return $response->setContent(\Zend\Json\Json::encode($result));
            }

        }
    }

    public function errorAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $post = $request->getPost();
        if ($post['error']) {
            $gameID = $this->sessionContainer->gameId;
            $game = $this->entityManager->getRepository(Game::class)->find($gameID);

            $this->sessionContainer->errors += 1;
            $errorCnt = $this->sessionContainer->errors;
            if ($errorCnt == 5 ) {
                $result = array('win' => 0, 'lost' => 1);
                $this->gameManager->updateGameResult($game, $result);
            } else {
                $this->gameManager->updateCurrentGameNegative($game);
            }
            $vm = new ViewModel();
            $vm->setTerminal(true);
            return $response->setContent(\Zend\Json\Json::encode($errorCnt));

        }
    }

    public function checkwordAction(){
        $request = $this->getRequest();
        $response = $this->getResponse();

        $post = $request->getPost();
        if ($post['word']) {
            if(isset($this->sessionContainer->selectedWord)) {
                $selectedWord = $this->sessionContainer->selectedWord;
                $word = $post['word'];
                $match = (mb_strtolower($selectedWord['word']) == mb_strtolower($word));

                $result = array('win' => 0, 'lost' => 0);
                //Save the result
                ($match) ? $result['win'] = 1 : $result['lost'] = 1;
                $gameID = $this->sessionContainer->gameId;
                $game = $this->entityManager->getRepository(Game::class)->find($gameID);
                $this->gameManager->changeGuessMethod($game);
                $this->gameManager->updateGameResult($game, $result);
                $vm = new ViewModel();
                $vm->setTerminal(true);
                return $response->setContent(\Zend\Json\Json::encode($match));
            }

        }
    }

    public function checkWordCompleteAction(){
        $request = $this->getRequest();
        $response = $this->getResponse();
        $post = $request->getPost();
        if ($post) {
            if(isset($this->sessionContainer->gameId)) {
                $gameID = $this->sessionContainer->gameId;
                /** @var  $game \Application\Entity\Game */
                $game = $this->entityManager->getRepository(Game::class)->find($gameID);

                //Check if game is finished
                if ($game->getCurrentLettersNum() == $game->getCurrentPositive()) {
                    $result = array('win' => 1, 'lost' => 0);
                    $this->gameManager->updateGameResult($game, $result);
                    $result = true;
                } else {
                    $result = false;
                }

                $vm = new ViewModel();
                $vm->setTerminal(true);
                return $response->setContent(\Zend\Json\Json::encode($result));
            }

        }
    }

    public function StatisticAction()
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByEmail($this->identity());
        $stat = $this->gameManager->getGameStatisticPerUser($user);

        return array('stat' => $stat);
    }



}

