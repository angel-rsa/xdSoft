<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Топ рейтинга за определенный день
 *
 * @ORM\Table(name="top")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Top
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Дата рейтинга
     * @var \DateTime
     * @ORM\Column(name="top_date", type="date")
     */
    private $date;

    /**
     * Название рейтинга
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * Позиции рейтинга
     * @ORM\OneToMany(targetEntity="TopItem", mappedBy="top", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $items;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

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
     * Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Top
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Top
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add items
     *
     * @param \AppBundle\Entity\TopItem $items
     * @return Top
     */
    public function addItem(TopItem $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \AppBundle\Entity\TopItem $items
     */
    public function removeItem(TopItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Top
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Top
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
