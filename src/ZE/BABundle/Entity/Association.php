<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 22/03/14
 * Time: 19:46
 */

namespace ZE\BABundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


    /**
    * An item a user can have a many to many relationship with, ie: Association, artist
    *
    * @ORM\Entity
    * @ORM\Table(name="association")
    * @ORM\InheritanceType("SINGLE_TABLE")
    * @ORM\DiscriminatorColumn(name="type", type="string")
    * @ORM\DiscriminatorMap({"association" = "Association", "association" = "association", "band" = "Band"})
    */
class Association
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    protected $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=500, nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="association",cascade={"persist"})
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="association", cascade={"persist"})
     */
    protected $documents;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="associations")
     * @ORM\JoinTable(name="association_genre",
     *   joinColumns={@ORM\JoinColumn(name="association_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     */
    protected $genres;




    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="associations")
     */
    protected $user;

    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @ORM\ManyToMany(targetEntity="Instrument", inversedBy="associations")
     * @ORM\JoinTable(name="association_instrument",
     *   joinColumns={@ORM\JoinColumn(name="association_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="instrument_id", referencedColumnName="id")}
     * )
     */
    protected $instruments;

    


    /**
     * Add instruments
     *
     * @param \ZE\BABundle\Entity\Instrument $instruments
     *
     * @return association
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

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->instruments = new ArrayCollection();
    }



    /**
     * Add documents
     *
     * @param \ZE\BABundle\Entity\Document $documents
     * @return Association
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
     * Get addresss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add addresss
     *
     * @param \ZE\BABundle\Entity\Address $addresss
     * @return Association
     */
    public function addAddress(\ZE\BABundle\Entity\Address $addresss)
    {
        $this->addresses[] = $addresss;

        return $this;
    }

    /**
     * Remove addresss
     *
     * @param \ZE\BABundle\Entity\Address $addresss
     */
    public function removeAddress(\ZE\BABundle\Entity\Address $addresss)
    {
        $this->addresses->removeElement($addresss);
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
     * @return Association
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
     * @return Association
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
     * @return Association
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

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}
