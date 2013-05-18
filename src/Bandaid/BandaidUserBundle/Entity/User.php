<?php

    namespace Bandaid\BandaidUserBundle\Entity;

    use FOS\UserBundle\Entity\User as BaseUser;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Entity that persists the user information
     *
     * @ORM\Entity
     * @ORM\Table(name="fos_user")
     *
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
         * Constructor
         */
        public function __construct()
        {
            parent::__construct();
            // your own logic
        }

        /**
         * Get id
         *
         * @return integer
         */
        public function getId()
        {
            return $this->id;
        }
    }
