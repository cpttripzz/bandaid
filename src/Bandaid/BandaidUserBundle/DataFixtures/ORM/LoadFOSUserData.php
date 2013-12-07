<?php

    namespace  Bandaid\BandaidUserBundle\DataFixtures\ORM;
    use Bandaid\BandaidUserBundle\Entity\EntityType;
    use Bandaid\BandaidUserBundle\Entity\Genre;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Bandaid\BandaidUserBundle\Entity\Entity;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    class LoadFOSUserData extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
    {
        /**
         * @var ContainerInterface
         */
        private $container;

        /**
         * {@inheritDoc}
         */
        public function setContainer(ContainerInterface $container = null)
        {
            $this->container = $container;
        }

        /**
         * {@inheritDoc}
         */
        public function load(ObjectManager $manager)
        {
            $userManager = $this->container->get('fos_user.user_manager');
            //make some users
            $user = $userManager->createUser();
            $user->setUsername('admin');
            $user->setEmail('admin@admin.com');
            $user->setPlainPassword('admin');
            $user->addRole('ROLE_SUPER_ADMIN');
            $user->setEnabled(true);
            $userManager->updateUser($user);

            $user = $userManager->createUser();
            $user->setUsername('user1');
            $user->setEmail('user1@user1.com');
            $user->setPlainPassword('user1');
            $userManager->updateUser($user);

        }

        public function getOrder()
        {
            return 1;
        }
    }