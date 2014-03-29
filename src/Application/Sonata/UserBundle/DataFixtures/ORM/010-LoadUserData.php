<?php
// src/Application/Sonata/UserBundle/DataFixtures/ORM/010-LoadUserData.php
namespace Application\Sonata\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use FOS\UserBundle\Entity\Group;
use Application\Sonata\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture
    implements OrderedFixtureInterface,
    FixtureInterface,
    ContainerAwareInterface
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
        $groupManager = $this->container->get('fos_user.group_manager');
        $filename = __DIR__ . DIRECTORY_SEPARATOR  . '011-LoadUserGroupData.yml';
        $yml      = Yaml::parse(file_get_contents($filename));
        foreach ($yml as $userReference => $data) {
            $group = $groupManager->createGroup($data['name']);
            $groupManager->updateGroup($group,true);
        }
        $filename = __DIR__ . DIRECTORY_SEPARATOR  . '010-LoadUserData.yml';
        $yml      = Yaml::parse(file_get_contents($filename));
        $userManager = $this->container->get('fos_user.user_manager');

        foreach ($yml as $userReference => $data) {
            $user = $userManager->createUser();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPlainPassword($data['plainPassword']);

            $user->setDateOfBirth(new \DateTime(strtotime($data['date_of_birth'])));
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setGender($data['gender']);
            $user->setPhone($data['phone']);
            $user->addGroup($groupManager->findGroupByName($data['group']));
            $user->setEnabled(true);

            if(isset($data['isAdmin']) && $data['isAdmin']){
                $user -> setRoles(array('ROLE_SUPER_ADMIN'));
            }

            $userManager->updateUser($user, true);
            $this->addReference($userReference, $user);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

}