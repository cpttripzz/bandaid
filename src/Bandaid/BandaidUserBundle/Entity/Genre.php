<?php

namespace Bandaid\BandaidUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity
 */
class Genre
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="genre_name", type="string", length=32, nullable=false)
     */
    private $genreName;

    private $entities;

    public function addEntity(Entity $entity){
        $this->entities[] = $entity;
    }

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
     * Set genreName
     *
     * @param string $genreName
     * @return Genre
     */
    public function setGenreName($genreName)
    {
        $this->genreName = $genreName;
    
        return $this;
    }

    /**
     * Get genreName
     *
     * @return string 
     */
    public function getGenreName()
    {
        return $this->genreName;
    }

    public function __toString()
    {
        return $this->genreName;
    }
}