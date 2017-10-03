<?php
namespace Application\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="games")
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Words", inversedBy="games")
     * @ORM\JoinColumn(name="currentWord", referencedColumnName="id")
     */
    protected $currentWord;

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\User", inversedBy="game")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(name="currentLettersNum")
     *
     * The  number of letter to guess
     */
    protected $currentLettersNum;

    /**
     * @ORM\Column(name="currentPositive")
     *
     * The  number of guessed letters
     */
    protected $currentPositive;

    /**
     * @ORM\Column(name="currentNegative")
     *
     * The  number of not guessed letters
     */
    protected $currentNegative;

    /**
     * @ORM\Column(name="win")
     *
     */
    protected $win;

    /**
     * @ORM\Column(name="lost")
     *
     */
    protected $lost;

    /**
     * @ORM\Column(name="letter")
     *
     */
    protected $letter;

    /**
     * @ORM\Column(name="word")
     *
     */
    protected $word;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCurrentWord()
    {
        return $this->currentWord;
    }

    /**
     * @param mixed $currentWord
     */
    public function setCurrentWord($currentWord)
    {
        $this->currentWord = $currentWord;
        $currentWord->addGame($this);
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \User\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        $user->addGame($this);
    }

    /**
     * @return mixed
     */
    public function getCurrentLettersNum()
    {
        return $this->currentLettersNum;
    }

    /**
     * @param mixed $currentLettersNum
     */
    public function setCurrentLettersNum($currentLettersNum)
    {
        $this->currentLettersNum = $currentLettersNum;
    }

    /**
     * @return mixed
     */
    public function getCurrentPositive()
    {
        return $this->currentPositive;
    }

    /**
     * @param mixed $currentPositive
     */
    public function setCurrentPositive($currentPositive)
    {
        $this->currentPositive = $currentPositive;
    }

    /**
     * @return mixed
     */
    public function getCurrentNegative()
    {
        return $this->currentNegative;
    }

    /**
     * @param mixed $currentNegative
     */
    public function setCurrentNegative($currentNegative)
    {
        $this->currentNegative = $currentNegative;
    }

    /**
     * @return mixed
     */
    public function getWin()
    {
        return $this->win;
    }

    /**
     * @param mixed $win
     */
    public function setWin($win)
    {
        $this->win = $win;
    }

    /**
     * @return mixed
     */
    public function getLost()
    {
        return $this->lost;
    }

    /**
     * @param mixed $lost
     */
    public function setLost($lost)
    {
        $this->lost = $lost;
    }

    /**
     * @return mixed
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * @param mixed $letter
     */
    public function setLetter($letter)
    {
        $this->letter = $letter;
    }

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }








}