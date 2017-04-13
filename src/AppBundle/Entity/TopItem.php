<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Позиция рейтинга
 * @ORM\Table(name="top_items")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class TopItem
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Топ, которому принадлежит позиция
     * @ORM\ManyToOne(targetEntity="Top", inversedBy="items")
     */
    private $top;

    /**
     * Название фильма
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Оригинальное название фильма
     * @var string
     * @ORM\Column(type="string")
     */
    private $originalName;

    /**
     * Позиция в рейтинге
     * @var int
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * Значение рейтинга
     * @var float
     * @ORM\Column(type="float")
     */
    private $rating;

    /**
     * Кол-во проголосовавших
     * @var int
     * @ORM\Column(type="integer")
     */
    private $voters;

    /**
     * Год выхода фильма
     * @var int
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return TopItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set originalName
     *
     * @param string $originalName
     * @return TopItem
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string 
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return TopItem
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set rating
     *
     * @param float $rating
     * @return TopItem
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set voters
     *
     * @param integer $voters
     * @return TopItem
     */
    public function setVoters($voters)
    {
        $this->voters = $voters;

        return $this;
    }

    /**
     * Get voters
     *
     * @return integer 
     */
    public function getVoters()
    {
        return $this->voters;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return TopItem
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set top
     *
     * @param \AppBundle\Entity\Top $top
     * @return TopItem
     */
    public function setTop(\AppBundle\Entity\Top $top = null)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return \AppBundle\Entity\Top 
     */
    public function getTop()
    {
        return $this->top;
    }
}
