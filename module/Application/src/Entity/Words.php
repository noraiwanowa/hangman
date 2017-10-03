<?php

namespace Application\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="words")
 */
class Words
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Categories", inversedBy="words")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /*
     * Returns associated category
     * @return \Application\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets associated category
     * @param \Application\Entity\Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
        $category->addWord($this);
    }

    /**
     * @ORM\Column(name="word")
     */
    protected  $word;


    /**
     * @ORM\Column(name="description")
     */
    protected  $description;


    /**
     * @return int
     *  Returns ID of the category
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * Sets Id of the category
     */
    public function setId($id)
    {
        $this->id = $id;
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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="currentWord")
     * @ORM\JoinColumn(name="id", referencedColumnName="currentWord")
     */
    protected $games;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->words = new ArrayCollection();
    }

    /**
     * @param mixed $games
     */
    public function setGames($games)
    {
        $this->games = $games;
    }



    /**
     * Returns games for this word.
     * @return array
     */
    public function getGames()
    {
        return $this->games;
    }


    public function addGame($game)
    {
        $this->games[] = $game;
    }





}