<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 13/06/14
 * Time: 20:45
 */

namespace ZE\BABundle\Event;


use Symfony\Component\EventDispatcher\Event;

class JoinBandRequestEvent extends Event
{
    protected $user;
    protected $bandId;

    public function __construct($user,$bandId)
    {
        $this->user = $user;
        $this->bandId = $bandId;
    }

    /**
     * @return mixed
     */
    public function getBandId()
    {
        return $this->bandId;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
} 