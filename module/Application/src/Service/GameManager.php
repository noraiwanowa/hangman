<?php

namespace Application\Service;

use Application\Entity\Game;

class GameManager
{

    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This method adds a new game.
     */
    public function addGame($data)
    {

        // Create new Game entity.
        $game = new Game();
        $game->setUser($data['user']);
        $game->setCurrentWord($data['word']);
        $game->setCurrentLettersNum($data['letterNum']);
        $game->setCurrentNegative(0);
        $game->setCurrentPositive(0);
        $game->setLost(0);
        $game->setWin(0);
        //By default is by letter
        $game->setLetter(1);
        $game->setWord(0);

        // Add the entity to the entity manager.
        $this->entityManager->persist($game);

        // Apply changes to database.
        $this->entityManager->flush();

        return $game;
    }

    /**
     * This method updates current possitive Result.
     * @param  $game \Application\Entity\Game
     */
    public function updateCurrentGamePositive($game, $cnt) {
        $positive = $game->getCurrentPositive();
        $positive += $cnt;
        $game->setCurrentPositive($positive);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;

    }

    /**
     * This method updates current possitive Result.
     * @param  $game \Application\Entity\Game
     */
    public function updateCurrentGameNegative($game) {
        $negative = $game->getCurrentNegative();
        $negative +=1;
        $game->setCurrentNegative($negative);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;

    }

    /**
     * Set guess method to word
     * @param  $game \Application\Entity\Game
     */
    public function changeGuessMethod($game) {

        $game->setLetter(0);
        $game->setWord(1);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;

    }



    /**
     * This method updates Game Result.
     * @param  $game \Application\Entity\Game
     */
    public function updateGameResult($game, $data)
    {
        $game->setWin($data['win']);
        $game->setLost($data['lost']);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }

    /**
     * This method returns User Game Statistics.
     */
    public function getGameStatisticPerUser($user) {
        $winGames = $this->entityManager ->getRepository(Game::class)->findBy(['user' => $user, 'win' => 1]);
        $cntWins = count($winGames);
        $lostGames = $this->entityManager ->getRepository(Game::class)->findBy(['user' => $user, 'lost' => 1]);
        $cntLost = count($lostGames);
        $allGames = $this->entityManager ->getRepository(Game::class)->findBy(['user' => $user]);
        $cntAll = count($allGames);
        $notFinished = $this->entityManager ->getRepository(Game::class)->findBy(['user' => $user, 'lost' => 0, 'win' => 0]);
        $cntNotFinished = count($notFinished);
        $byLetter = $this->entityManager ->getRepository(Game::class)->findBy(['user' => $user, 'letter' => 1]);
        $cntByletter = count($byLetter);
        $byWord = $this->entityManager ->getRepository(Game::class)->findBy(['user' => $user, 'word' => 1]);
        $cntByWord = count($byWord);

        return array('wins'=>$cntWins, 'loss' =>$cntLost, 'all' => $cntAll, 'notFinished' => $cntNotFinished, 'byLetter' => $cntByletter, 'byWord' => $cntByWord);

    }

    /**
     * This method returns User Game Statistics.
     */
    public function getCurrentGamePerUser($user) {
        //$allGames = $this->entityManager ->getRepository(Game::class)->findByUser($user);
        //$allGames = $this->entityManager ->getRepository(Game::class)->findBy('userId' => $user->getId());

        $currentGame = $this->entityManager ->getRepository(Game::class)->findBy(['user' => $user, 'lost' => 0, 'win'=>0]);

        return $currentGame;

    }


}