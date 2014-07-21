<?php

namespace ZE\BABundle\Service\Util;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;
use ZE\BABundle\Entity\Band;
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
}