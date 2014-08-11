<?php

namespace ZE\BABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
/**
 *
 * @ORM\Table(name="band_vacancy")
 * @ORM\Entity
 */
class BandVacancy
{
    use TimestampableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="BandVacancyAssociation", mappedBy="bandVacancies")
     */
    private $bandVacancyAssociations;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="bandVacancies")
     */
    private $genres;

    /** @ORM\Column(name="comment", type="text",nullable=true) */
    private $comment;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bandVacancyAssociations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name.

     *
     * @param \DateTime $name
     *
     * @return BandVacancy
     */
    public function setComment($name)
    {
        $this->comment = $name;

        return $this;
    }

    /**
     * Get name.

     *
     * @return \DateTime
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Add bandVacancyAssociation.

     *
     * @param \ZE\BABundle\Entity\BandVacancyAssociation $bandVacancyAssociation
     *
     * @return BandVacancy
     */
    public function addBandVacancyAssociation(\ZE\BABundle\Entity\BandVacancyAssociation $bandVacancyAssociation)
    {
        $this->bandVacancyAssociations[] = $bandVacancyAssociation;

        return $this;
    }

    /**
     * Remove bandVacancyAssociation.

     *
     * @param \ZE\BABundle\Entity\BandVacancyAssociation $bandVacancyAssociation
     */
    public function removeBandVacancyAssociation(\ZE\BABundle\Entity\BandVacancyAssociation $bandVacancyAssociation)
    {
        $this->bandVacancyAssociations->removeElement($bandVacancyAssociation);
    }

    /**
     * Get bandVacancyAssociations.

     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBandVacancyAssociations()
    {
        return $this->bandVacancyAssociations;
    }

    /**
     * Add genre.

     *
     * @param \ZE\BABundle\Entity\Genre $genre
     *
     * @return BandVacancy
     */
    public function addGenre(\ZE\BABundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre.

     *
     * @param \ZE\BABundle\Entity\Genre $genre
     */
    public function removeGenre(\ZE\BABundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres.

     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }
}
