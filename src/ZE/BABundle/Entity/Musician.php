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
    * @ORM\Entity
    * @ORM\Table(name="musician")
    */
class Musician
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected  $id;


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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=500, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Address",cascade={"persist"})
     * @ORM\JoinTable(name="musicians_addresses",
     *      joinColumns={@ORM\JoinColumn(name="musician_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="address_id", referencedColumnName="id")}
     *      )
     */
    private $addresses;

    /**
     * @ORM\ManyToMany(targetEntity="Document")
     * @ORM\JoinTable(name="musicians_documents",
     *      joinColumns={@ORM\JoinColumn(name="musician_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id")}
     *      )
     */
    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity="Genre")
     * @ORM\JoinTable(name="musicians_genres",
     *      joinColumns={@ORM\JoinColumn(name="musician_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     *      )
     */

    private $genres;

    /**
     * @ORM\ManyToMany(targetEntity="Instrument")
     * @ORM\JoinTable(name="musicians_instruments",
     *      joinColumns={@ORM\JoinColumn(name="musician_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="instrument_id", referencedColumnName="id")}
     *      )
     */

    private $instruments;


    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }


   
    /**
     * Add documents
     *
     * @param \ZE\BABundle\Entity\Document $documents
     * @return Musician
     */
    public function addDocument(\ZE\BABundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \ZE\BABundle\Entity\Document $documents
     */
    public function removeDocument(\ZE\BABundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add genres
     *
     * @param \ZE\BABundle\Entity\Genre $genres
     * @return Musician
     */
    public function addGenre(\ZE\BABundle\Entity\Genre $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Remove genres
     *
     * @param \ZE\BABundle\Entity\Genre $genres
     */
    public function removeGenre(\ZE\BABundle\Entity\Genre $genres)
    {
        $this->genres->removeElement($genres);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Musician
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Musician
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
     * Add instruments
     *
     * @param \ZE\BABundle\Entity\Instrument $instruments
     *
     * @return Musician
     */
    public function addInstrument(\ZE\BABundle\Entity\Instrument $instruments)
    {
        $this->instruments[] = $instruments;

        return $this;
    }

    /**
     * Remove instruments
     *
     * @param \ZE\BABundle\Entity\Instrument $instruments
     */
    public function removeInstrument(\ZE\BABundle\Entity\Instrument $instruments)
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

   


    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add addresses
     *
     * @param \ZE\BABundle\Entity\Address $addresses
     *
     * @return Musician
     */
    public function addAddress(\ZE\BABundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \ZE\BABundle\Entity\Address $addresses
     */
    public function removeAddress(\ZE\BABundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }
}
