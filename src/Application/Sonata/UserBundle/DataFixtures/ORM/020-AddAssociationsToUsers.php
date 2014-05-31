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
use ZE\BABundle\Entity;

class AddAssociationsToUsers extends AbstractFixture
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
        $filename = __DIR__ . DIRECTORY_SEPARATOR . '020-AddAssociationsToUsers.yml';
        $yml = Yaml::parse(file_get_contents($filename));
        $userManager = $this->container->get('fos_user.user_manager');
        foreach ($yml as $key => $data) {
            $user = $userManager->findUserByUsername($data['username']);
//            $user = new Entity\User();
            if (!empty($data['bands'])) {
                foreach ($data['bands'] as $index => $bandData) {
                    $band = new Entity\Band();
                    $band->setName($bandData['name']);
                    $band->setDescription($bandData['description']);
                    $genres = explode(',', $bandData['genres']);
                    foreach ($genres as $genre) {
                        $g = $manager->getRepository('ZE\BABundle\Entity\Genre')->findOneByName(trim($genre));
                        $band->addGenre($g);
                    }
                    foreach ($bandData['addresses'] as $addressData) {
                        $address = new Entity\Address();
                        $c = $manager->getRepository('ZE\BABundle\Entity\City')->findOneByName(trim($addressData['city']));
                        $address->setCity($c);
                        $address->setAddress($addressData['address']);
                        $manager->persist($address);
                        $band->addAddress($address);

                    }

                    $manager->persist($band);
                    $band->setUser($user);
                    $user->addBand($band);
                }
            }
            if (!empty($data['musicians'])) {
                foreach ($data['musicians'] as $index => $musicianData) {
                    $musician = new Entity\Musician();
                    $musician->setName($musicianData['name']);
                    $musician->setDescription($musicianData['description']);
                    $genres = explode(',', $musicianData['genres']);
                    foreach ($genres as $genre) {
                        $g = $manager->getRepository('ZE\BABundle\Entity\Genre')->findOneByName(trim($genre));
                        $musician->addGenre($g);
                    }

                    foreach ($musicianData['addresses'] as $addressData) {
                        $address = new Entity\Address();
                        $c = $manager->getRepository('ZE\BABundle\Entity\City')->findOneByName(trim($addressData['city']));
                        $address->setCity($c);
                        $address->setAddress($addressData['address']);
                        $musician->addAddress($address);

                    }
                    $instruments = explode(',', $musicianData['instruments']);
                    foreach ($instruments as $instrument) {
                        $g = $manager->getRepository('ZE\BABundle\Entity\Instrument')->findOneByName(trim($instrument));
                        $musician->addInstrument($g);
                    }
                    $manager->persist($musician);
                    $musician->setUser($user);
                    $user->addMusician($musician);
                }
            }
            $userManager->updateUser($user, true);

        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }

}