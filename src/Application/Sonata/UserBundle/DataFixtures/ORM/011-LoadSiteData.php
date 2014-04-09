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
use ZE\BABundle\Entity;

class LoadSiteData extends AbstractFixture
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
        $filename = __DIR__ . DIRECTORY_SEPARATOR  . '011-LoadSiteData.yml';
        $yml      = Yaml::parse(file_get_contents($filename));
        foreach ( $yml['countries'] as $key => $data) {
            $country = new Entity\Country();
            $country->setCountryName($data['country_name']);
            $country->setCountryCode($data['country_code']);

            $manager->persist($country);
            $manager->flush();
        }
        foreach ( $yml['cities'] as $key => $data) {
            $city = new Entity\City();
            $city->setName($data['city']);
            $country = $manager->getRepository('ZE\BABundle\Entity\Country')->findOneByCountryCode(trim($data['country_code']));
            $city->setCountry($country);
            $manager->persist($city);
            $manager->flush();
        }

        foreach ( $yml['genres'] as $key => $data) {
            $genre = new Entity\Genre();
            $genre->setName($data['name']);
            $manager->persist($genre);
            $manager->flush();
        }

        foreach ( $yml['instruments'] as $key => $data) {
            $instrument = new Entity\Instrument();
            $instrument->setName($data['name']);
            $manager->persist($instrument);
            $manager->flush();
        }

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

}