<?php

namespace ZE\BABundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ZE\BABundle\Entity\Repository\Band")
 */
class Band extends Association
{


    /**
     * @ORM\ManyToMany(targetEntity="Musician", inversedBy="bands")
     * @ORM\JoinTable(name="band_musician",
     *   joinColumns={@ORM\JoinColumn(name="band_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="musician_id", referencedColumnName="id")}
     * )
     */
    private $musicians;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->musicians = new ArrayCollection();
    }


    public function addMusician(\ZE\BABundle\Entity\Musician $musician)
    {
        $this->musicians[] = $musician;

        return $this;
    }


    public function removeMusician(\ZE\BABundle\Entity\Musician $musician)
    {
        $this->musicians->removeElement($musician);
    }

    public function getMusicians()
    {
        return $this->musicians;
    }


}
