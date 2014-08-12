<?php

namespace ZE\BABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * BandVacancyAssociation
 *
 * @ORM\Table(name="band_vacancy_association")
 * @ORM\Entity
 */
class BandVacancyAssociation
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
     * @ORM\ManyToOne(targetEntity="Band", inversedBy="bandVacancyAssociations")
     */
    private $band;

    /**
     * @ORM\ManyToOne(targetEntity="BandVacancy", inversedBy="bandVacancyAssociations")
     */
    private $bandVacancies;


    /**
     * Get id.

     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set band.

     *
     * @param \ZE\BABundle\Entity\Band $band
     *
     * @return BandVacancyAssociation
     */
    public function setBand(\ZE\BABundle\Entity\Band $band = null)
    {
        $this->band = $band;

        return $this;
    }

    /**
     * Get band.

     *
     * @return \ZE\BABundle\Entity\Band
     */
    public function getBand()
    {
        return $this->band;
    }

    /**
     * Set bandVacancyAssociations.

     *
     * @param \ZE\BABundle\Entity\BandVacancy $bandVacancyAssociations
     *
     * @return BandVacancyAssociation
     */
    public function setBandVacancyAssociations(\ZE\BABundle\Entity\BandVacancy $bandVacancyAssociations = null)
    {
        $this->bandVacancyAssociations = $bandVacancyAssociations;

        return $this;
    }

    /**
     * Get bandVacancyAssociations.

     *
     * @return \ZE\BABundle\Entity\BandVacancy
     */
    public function getBandVacancyAssociations()
    {
        return $this->bandVacancyAssociations;
    }

    /**
     * Set bandVacancies.

     *
     * @param \ZE\BABundle\Entity\BandVacancy $bandVacancies
     *
     * @return BandVacancyAssociation
     */
    public function setBandVacancies(\ZE\BABundle\Entity\BandVacancy $bandVacancies = null)
    {
        $this->bandVacancies = $bandVacancies;

        return $this;
    }

    /**
     * Get bandVacancies.

     *
     * @return \ZE\BABundle\Entity\BandVacancy
     */
    public function getBandVacancies()
    {
        return $this->bandVacancies;
    }
}
