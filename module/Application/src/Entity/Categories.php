<?php

namespace Application\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Words;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Categories
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="category")
     */
    protected $category;

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
     * @return string
     * Returns the name of the category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     * Sets the name of the category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @ORM\OneToMany(targetEntity="Words", mappedBy="category")
     * @ORM\JoinColumn(name="id", referencedColumnName="category_id")
     */
    protected $words;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->words = new ArrayCollection();
    }

    /**
     * @param mixed $words
     */
    public function setWords($words)
    {
        $this->words = $words;
    }



    /**
     * Returns words for this category.
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }


    public function addWord($word)
    {
        $this->words[] = $word;
    }


}