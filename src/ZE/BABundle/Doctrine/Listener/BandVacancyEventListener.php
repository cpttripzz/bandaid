<?php
namespace ZE\BABundle\Doctrine\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZE\BABundle\Entity\Association;
use ZE\BABundle\Entity\Band;
use ZE\BABundle\Entity\BandVacancyAssociation;

class BandVacancyEventListener
{
    protected  $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /** @ORM\PrePersist */
    public function prePersist(LifecycleEventArgs $eventArgs) {
        if (!empty($this->container->get('security.context')->getToken())) {
            if (($association = $eventArgs->getEntity()) instanceof BandVacancyAssociation) {
                $band = $eventArgs->getObjectManager();
                $em = $eventArgs->getEntityManager();
                $uow = $em->getUnitOfWork();
                $entities = $uow->getIdentityMap();
                $entities = $entities['ZE\BABundle\Entity\Association'];
                foreach ($entities as $entity){
                    if(!($entity instanceof Band)){
                        continue;
                    }
                    $association->setBand($entity);
                }
            }
        }
    }
}