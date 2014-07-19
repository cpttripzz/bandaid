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
use  React\ZMQ\Context;

class JoinBandRequestEventListener
{
    protected $msgService;
    protected $em;

    public function __construct(Container $container)
    {
        $this->em = $container->get('doctrine');
        $this->msgService = $container->get('snc_redis.default');
    }

    public function onJoinBandRequestEvent(JoinBandRequestEvent $event)
    {
        $requestingUser = $event->getUser();
        $requestingUserId = $requestingUser->getId();
        $username = $requestingUser->getUsername();
        $bandId = $event->getBandId();
        $band = $this->em->getRepository('ZE\BABundle\Entity\Band')->findOneById($bandId);
        $bandName = $band->getName();
        $eventType = $event->getEventType();
        $bandMembers = $this->em->getRepository('ZE\BABundle\Entity\BandMusician')->findAllMusiciansByBandId($event->getBandId());

        $msgRecipients = array();
        foreach ((array)$bandMembers as $bandMember) {
            $userId = $bandMember->getMusician()->getUser()->getId();

            $nextMessageId = $this->msgService->incr('next_message_id');
            $this->msgService->hmset(
                'message:' . $nextMessageId,
                'fromUser', $requestingUserId,
                'bandId', $bandId,
                'messageType', $eventType,
                'subject', 'User ' . $username . ' requested to join band ' . $bandName
            );
            $this->msgService->rpush('messages:' . $userId, $nextMessageId);
            $numNewMessages = $this->msgService->incr('new_messages:' . $userId);
            $msgRecipients[$userId] = $numNewMessages;
        }
        $this->msgService->publish('realtime', json_encode($msgRecipients));
        $nextMessageId = $this->msgService->incr('publisher_count');
    }


}