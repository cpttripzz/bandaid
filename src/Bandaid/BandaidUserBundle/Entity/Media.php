<?php

namespace Bandaid\BandaidUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity
 */
class Media
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
     * @ORM\Column(name="filename", type="integer", nullable=false)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=3, nullable=true)
     */
    private $extension;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=true)
     */
    private $isPublic;

    /**
     * @var \MediaType
     *
     * @ORM\ManyToOne(targetEntity="MediaType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;



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
     * Set filename
     *
     * @param integer $filename
     * @return Media
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return integer 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Media
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    
        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Media
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    
        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set type
     *
     * @param \Bandaid\BandaidUserBundle\Entity\MediaType $type
     * @return Media
     */
    public function setType(\Bandaid\BandaidUserBundle\Entity\MediaType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Bandaid\BandaidUserBundle\Entity\MediaType 
     */
    public function getType()
    {
        return $this->type;
    }
}