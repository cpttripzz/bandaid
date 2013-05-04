<?php

namespace Bandaid\BandaidUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntityGenre
 *
 * @ORM\Table(name="entity_genre")
 * @ORM\Entity
 */
class EntityGenre
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
     * @var \Genre
     *
     * @ORM\ManyToOne(targetEntity="Genre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     * })
     */
    private $genre;

    /**
     * @var \Entity
     *
     * @ORM\ManyToOne(targetEntity="Entity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     * })
     */
    private $entity;



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
     * Set genre
     *
     * @param \Bandaid\BandaidUserBundle\Entity\Genre $genre
     * @return EntityGenre
     */
    public function setGenre(\Bandaid\BandaidUserBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;
    
        return $this;
    }

    /**
     * Get genre
     *
     * @return \Bandaid\BandaidUserBundle\Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set entity
     *
     * @param \Bandaid\BandaidUserBundle\Entity\Entity $entity
     * @return EntityGenre
     */
    public function setEntity(\Bandaid\BandaidUserBundle\Entity\Entity $entity = null)
    {
        $this->entity = $entity;
    
        return $this;
    }

    /**
     * Get entity
     *
     * @return \Bandaid\BandaidUserBundle\Entity\Entity 
     */
    public function getEntity()
    {
        return $this->entity;
    }
}