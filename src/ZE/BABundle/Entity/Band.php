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
     * @ORM\ManyToMany(targetEntity="City")
     * @ORM\JoinTable(name="bands_cities",
     *      joinColumns={@ORM\JoinColumn(name="bands_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="city_id", referencedColumnName="id")}
     *      )
     */
    private $cities;

    /**
     * @ORM\ManyToMany(targetEntity="Document")
     * @ORM\JoinTable(name="bands_documents",
     *      joinColumns={@ORM\JoinColumn(name="bands_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id")}
     *      )
     */
    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity="Genre")
     * @ORM\JoinTable(name="bands_genres",
     *      joinColumns={@ORM\JoinColumn(name="bands_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     *      )
     */


    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }



    /**
     * Add cities
     *
     * @param \ZE\BABundle\Entity\City $cities
     * @return Band
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
}
