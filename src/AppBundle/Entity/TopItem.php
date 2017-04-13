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
    private $title;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
