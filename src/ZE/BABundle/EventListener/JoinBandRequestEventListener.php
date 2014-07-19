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
        $user = $event->getUser();
        $bandMembers = $this->em->getRepository('ZE\BABundle\Entity\BandMusician')->getAllMusiciansByBandId($event->getBandId());

            $msgRecipients = array();
            foreach ((array) $bandMembers as $bandMember) {
                $userId = $bandMember->getMusician()->getUser()->getId();
                $username = $bandMember->getMusician()->getUser()->getUsername();
                $nextMessageId = $this->msgService->incr('next_message_id');
                $this->msgService->hmset(
                    'message:' . $nextMessageId,
                    'fromUser:', $user->getId(),
                    'messageType', 'JOIN',
                    'subject', 'Join Request'
                );
                $this->msgService->lpush('messages:' . $userId, $nextMessageId);
                $numNewMessages = $this->msgService->incr('new_messages:' . $userId);
                $msgRecipients[$userId] = $numNewMessages;
            }
            $this->msgService->publish('realtime', json_encode($msgRecipients));
            $nextMessageId = $this->msgService->incr('publisher_count');
        }



} 