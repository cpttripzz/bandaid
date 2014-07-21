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
use ZE\BABundle\Event\JoinBandAcceptEvent;
use ZE\BABundle\Entity\BandMusician;

class JoinBandAcceptEventListener
{
    protected $msgService;
    protected $em;

    public function __construct(Container $container)
    {
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->msgService = $container->get('snc_redis.default');
    }

    public function onJoinBandAcceptEvent(JoinBandAcceptEvent $event)
    {
        $user = $event->getUser();
        $userId = $user->getId();
        $bandId = $event->getBandId();
        $band = $this->em->getRepository('ZE\BABundle\Entity\Band')->findOneById($bandId);
        $bandName = $band->getName();
        $musicianId = $event->getMusicianId();
        $musician = $this->em->getRepository('ZE\BABundle\Entity\Musician')->findOneById($musicianId);
        $eventType = $event->getEventType();
        $recipientId = $musician->getUser()->getId();
//        $bandMusician = new BandMusician();
//        $bandMusician->setBand($band);
//        $bandMusician->setMusician($musician);
//        $bandMusician->setStatus(0);
//        $this->em->persist($bandMusician);
//        $this->em->flush();
        $now = new \DateTime();
        $now = $now->format('Y-m-d H:i:s');
        $nextMessageId = $this->msgService->incr('next_message_id');

        $this->msgService->hmset(
            'message:' . $nextMessageId,
            'musicianId', $userId,
            'bandId', $bandId,
            'messageType', $eventType,
            'sent', $now,
            'message', 'You are now a member of band [band]'
        );
        $this->msgService->rpush('messages:' . $recipientId, $nextMessageId);
        $numNewMessages = $this->msgService->incr('new_messages:' . $recipientId);
        $msgRecipients[$recipientId] = $numNewMessages;
        $this->msgService->publish('realtime', json_encode($msgRecipients));
    }


}