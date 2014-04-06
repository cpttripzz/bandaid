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


    /**
    * An item a user can have a many to many relationship with, ie: band, artist
    *
    * @ORM\Entity
    * @ORM\InheritanceType("SINGLE_TABLE")
    * @ORM\DiscriminatorColumn(name="discr", type="string")
    * @ORM\DiscriminatorMap({"band" = "Band", "musician" = "Musician"})
    */
class Association
{
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
     * @ORM\ManyToMany(targetEntity="City", inversedBy="Association", cascade={"persist"})
     * @ORM\JoinTable(name="associations_cities")
     **/
    private $cities;

    /**
     * @ORM\ManyToMany(targetEntity="Document", inversedBy="Association", cascade={"persist"})
     * @ORM\JoinTable(name="associations_documents")
     **/
    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="Association", cascade={"persist"})
     * @ORM\JoinTable(name="associations_genres")
     **/
    private $genres;


    public function __construct()
    {
        parent::__construct();
        $this->documents = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }


    /**
     * Add cities
     *
     * @param \ZE\BABundle\Entity\City $cities
     * @return Association
     */
    public function addCity(\ZE\BABundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \ZE\BABundle\Entity\City $cities
     */
    public function removeCity(\ZE\BABundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCities()
    {
        return $this->cities;
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
     * @param \ZE\BABundle\Entity\Genres $genres
     * @return Association
     */
    public function addGenre(\ZE\BABundle\Entity\Genres $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Remove genres
     *
     * @param \ZE\BABundle\Entity\Genres $genres
     */
    public function removeGenre(\ZE\BABundle\Entity\Genres $genres)
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
}
