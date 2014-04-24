<?php


namespace ZE\BABundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="musician")
 */
class Musician extends Association
{
    /**
     * @ORM\ManyToMany(targetEntity="Instrument", inversedBy="musicians")
     * @ORM\JoinTable(name="musician_instrument",
     *   joinColumns={@ORM\JoinColumn(name="musician_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="instrument_id", referencedColumnName="id")}
     * )
     */
    protected $instruments;

    public function __construct()
    {
        parent::__construct();
        $this->instruments = new ArrayCollection();
    }



    /**
     * Add instruments
     *
     * @param \ZE\BABundle\Entity\Instrument $instruments
     *
     * @return Musician
     */
    public function addInstrument(Instrument $instruments)
    {
        $this->instruments[] = $instruments;

        return $this;
    }

    /**
     * Remove instruments
     *
     * @param \ZE\BABundle\Entity\Instrument $instruments
     */
    public function removeInstrument(Instrument $instruments)
    {
        $this->instruments->removeElement($instruments);
    }

    /**
     * Get instruments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstruments()
    {
        return $this->instruments;
    }


}
