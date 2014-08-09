<?php

namespace ZE\BABundle\Service\Util;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;
use ZE\BABundle\Entity\Band;
use ZE\BABundle\Entity\BandMusician;
use ZE\BABundle\Entity\Address;
use ZE\BABundle\Entity\Musician;

class BandManager
{
    private $security;
    private $em;
    public function __construct(SecurityContext $security, EntityManager $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    public function isUserInBand(Band $band)
    {
        if( !$this->security->isGranted('IS_AUTHENTICATED_FULLY') ){
            return false;
        }
        $bandMembers = $this->em->getRepository('ZE\BABundle\Entity\BandMusician')->findAllMusiciansByBandId($band->getId());
        foreach ($bandMembers as $bandMember){
            if($bandMember->getMusician()->getUser()->getId() ==  $this->security->getToken()->getUser()->getId()){
                return true;
            }
        }
        return false;

    }
    public function findAllAssociationsByProximityToAddress($associationType,Address $address)
    {
        $addresses = $this->em->getRepository('ZEBABundle:Address')->getClosestAddresses($address);
        $addressIds = array();
        foreach($addresses as $address){
            $addressIds[] = $address->getId();
        }
        $associations = $this->em->getRepository('ZEBABundle:Association')
            ->getAllAssociationsByTypeAndAddressIds($associationType,$addressIds);
        return $associations;
    }

    public function isMusicianInBand(Musician $musician, Band $band)
    {
        $musicianId = $musician->getId();
        $bandMembers = $this->em->getRepository('ZE\BABundle\Entity\BandMusician')->findAllMusiciansByBandId($band->getId());
        foreach ($bandMembers as $bandMember){
            if($bandMember->getMusician()->getId() ==  $musicianId ){
                return true;
            }
        }
        return false;
    }
    public function addMusicianToBand(Musician $musician, Band $band)
    {
        if($this->isMusicianInBand($musician,$band)){
            return false;
        }
        $bandMusician = new BandMusician();
        $bandMusician->setBand($band);
        $bandMusician->setMusician($musician);
        $bandMusician->setStatus(1);
        $this->em->persist($bandMusician);
        $this->em->flush();
    }
}