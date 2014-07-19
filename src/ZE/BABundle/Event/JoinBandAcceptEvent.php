<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 13/06/14
 * Time: 20:45
 */

namespace ZE\BABundle\Event;


use Symfony\Component\EventDispatcher\Event;

class JoinBandAcceptEvent extends AbstractBandEvent
{

    public function __construct($user,$bandId)
    {
        parent::__construct($user,$bandId);
        $this->eventType = 'accept-band';
    }

} 