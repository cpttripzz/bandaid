<?php

namespace Bandaid\BandaidUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity
 *
 * @ORM\Table(name="entity")
 * @ORM\Entity
 */
class Entity
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \EntityType
     *
     * @ORM\ManyToOne(targetEntity="EntityType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entity_type", referencedColumnName="id")
     * })
     */
    private $entityType;



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
     * Set description
     *
     * @param string $description
     * @return Entity
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set entityType
     *
     * @param \Bandaid\BandaidUserBundle\Entity\EntityType $entityType
     * @return Entity
     */
    public function setEntityType(\Bandaid\BandaidUserBundle\Entity\EntityType $entityType = null)
    {
        $this->entityType = $entityType;
    
        return $this;
    }

    /**
     * Get entityType
     *
     * @return \Bandaid\BandaidUserBundle\Entity\EntityType 
     */
    public function getEntityType()
    {
        return $this->entityType;
    }
}