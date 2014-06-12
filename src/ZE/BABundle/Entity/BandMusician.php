<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 22/03/14
 * Time: 19:46
 */

namespace ZE\BABundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="band_musician")
 * @ORM\Entity
 */
class BandMusician
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\ManyToOne(targetEntity="Musician",inversedBy="bands") */
    protected $musician;

    /** @ORM\ManyToOne(targetEntity="Band",inversedBy="musicians") */
    protected $band;

    /**
     * @ORM\Column(name="status", type="integer",nullable=false)
     */
    private $status;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->band = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set status
     *
     * @param integer $status
     *
     * @return BandMusician
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set musician
     *
     * @param \ZE\BABundle\Entity\Musician $musician
     *
     * @return BandMusician
     */
    public function setMusician(\ZE\BABundle\Entity\Musician $musician = null)
    {
        $this->musician = $musician;

        return $this;
    }

    /**
     * Get musician
     *
     * @return \ZE\BABundle\Entity\Musician
     */
    public function getMusician()
    {
        return $this->musician;
    }

    /**
     * Set band
     *
     * @param \ZE\BABundle\Entity\Band $band
     *
     * @return BandMusician
     */
    public function setBand(\ZE\BABundle\Entity\Band $band = null)
    {
        $this->band = $band;

        return $this;
    }

    /**
     * Get band
     *
     * @return \ZE\BABundle\Entity\Band
     */
    public function getBand()
    {
        return $this->band;
    }
}
