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
    * @ORM\Table(name="band")
    */
class Band
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
     * @ORM\ManyToMany(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinTable(name="bands_addresses",
     *      joinColumns={@ORM\JoinColumn(name="band_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="address_id", referencedColumnName="id")}
     *      )
     */
    private $addresses;

    /**
     * @ORM\ManyToMany(targetEntity="Document")
     * @ORM\JoinTable(name="bands_documents",
     *      joinColumns={@ORM\JoinColumn(name="band_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id")}
     *      )
     */
    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity="Genre")
     * @ORM\JoinTable(name="bands_genres",
     *      joinColumns={@ORM\JoinColumn(name="band_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     *      )
     */
    private $genres;


    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }



    /**
     * Add addresses
     *
     * @param \ZE\BABundle\Entity\City $addresses
     * @return Band
     */
    public function addCity(\ZE\BABundle\Entity\City $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \ZE\BABundle\Entity\City $addresses
     */
    public function removeCity(\ZE\BABundle\Entity\City $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCities()
    {
        return $this->addresses;
    }

    /**
     * Add documents
     *
     * @param \ZE\BABundle\Entity\Document $documents
     * @return Band
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
     * @return Band
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
     * @return Band
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
     * @return Band
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
     * Add addresses
     *
     * @param \ZE\BABundle\Entity\Address $addresses
     *
     * @return Band
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

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}
