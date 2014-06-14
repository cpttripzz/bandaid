<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 13/06/14
 * Time: 20:50
 */

namespace ZE\BABundle\EventListener;


use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use ZE\BABundle\Event\JoinBandRequestEvent;

class JoinBandRequestEventListener
{
    protected $msgService;
    protected $em;

    public function __construct(Container $container)
    {
        $this->em = $container->get('doctrine');
        $this->msgService = $container->get('old_sound_rabbit_mq.join_band_producer');

    }

    public function onJoinBandRequestEvent(JoinBandRequestEvent $event)
    {
        $user = $event->getUser();
//        $band = $this->em->getRepository('ZE\BABundle\Entity\Band')->find($event->getBandId());
        $msg = array('user_id'=>$user->getId(),$event->getBandId() );
        $this->msgService->setDeliveryMode(2);
        $this->msgService->publish(serialize($msg));
    }
} 