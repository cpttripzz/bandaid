<?php

namespace Bandaid\BandaidUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntityMedia
 *
 * @ORM\Table(name="entity_media")
 * @ORM\Entity
 */
class EntityMedia
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
     * @var integer
     *
     * @ORM\Column(name="media_type", type="integer", nullable=false)
     */
    private $mediaType;

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
     * @var \Media
     *
     * @ORM\ManyToOne(targetEntity="Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * })
     */
    private $media;



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
     * Set mediaType
     *
     * @param integer $mediaType
     * @return EntityMedia
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
    
        return $this;
    }

    /**
     * Get mediaType
     *
     * @return integer 
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Set entity
     *
     * @param \Bandaid\BandaidUserBundle\Entity\Entity $entity
     * @return EntityMedia
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

    /**
     * Set media
     *
     * @param \Bandaid\BandaidUserBundle\Entity\Media $media
     * @return EntityMedia
     */
    public function setMedia(\Bandaid\BandaidUserBundle\Entity\Media $media = null)
    {
        $this->media = $media;
    
        return $this;
    }

    /**
     * Get media
     *
     * @return \Bandaid\BandaidUserBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }
}