<?php

namespace ZE\BABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Address
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="ZE\BABundle\Entity\Repository\Address")
 */
class Address
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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=256, nullable=true)
     */
    private $address;


    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="float", precision=7, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="float", precision=7, nullable=true)
     */
    private $longitude;

    /**
     * @var \City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;


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
     * Set address
     *
     * @param string $address
     *
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Address
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Address
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set city
     *
     * @param \ZE\BABundle\Entity\City $city
     *
     * @return Address
     */
    public function setCity(\ZE\BABundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \ZE\BABundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    public function __toString()
    {
        return $this->address . ' ' . $this->getCity()->getName();
    }

    /**
     * @ORM\ManyToOne(targetEntity="Association", inversedBy="addresses")
     **/
    protected $association;

    public function setAssociation(Association $association)
    {
        $this->association = $association;
    }


}
