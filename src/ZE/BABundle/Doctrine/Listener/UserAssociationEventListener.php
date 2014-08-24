<?php
namespace ZE\BABundle\Doctrine\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZE\BABundle\Entity\Association;

class UserAssociationEventListener
{
    protected  $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /** @ORM\PrePersist */
    public function prePersist(LifecycleEventArgs $eventArgs) {
        if (!empty($this->container->get('security.context')->getToken())) {
            if (($association = $eventArgs->getEntity()) instanceof Association) {
                $association->setUser($this->container->get('security.context')->getToken()->getUser());
            }
        }
    }
}