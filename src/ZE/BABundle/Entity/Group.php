<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 22/03/14
 * Time: 19:46
 */

namespace ZE\BABundle\Entity;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}