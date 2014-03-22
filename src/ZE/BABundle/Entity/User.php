<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 22/03/14
 * Time: 19:46
 */

namespace ZE\BABundle\Entity;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToOne(targetEntity="City")
     * JoinColumn(name="city_id", referencedColumnName="id")
     **/


    private $user;


    public function setUser(User $user){
        $this->user = $user;
    }
}