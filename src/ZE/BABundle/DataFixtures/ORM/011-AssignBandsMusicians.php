<?php
// src/Application/Sonata/UserBundle/DataFixtures/ORM/010-LoadUserData.php
namespace Application\Sonata\UserBundle\DataFixtures\ORM;
use Symfony\Component\HttpFoundation\File;
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
use Faker;
use ZE\BABundle\Entity\Address;
use ZE\BABundle\Entity\Band;
use ZE\BABundle\Entity\BandMusician;
use ZE\BABundle\Entity\City;
use ZE\BABundle\Entity\Country;
use ZE\BABundle\Entity\Document;
use ZE\BABundle\Entity\Genre;
use ZE\BABundle\Entity\Instrument;
use ZE\BABundle\Entity\Item;
use ZE\BABundle\Entity\Musician;
use ZE\BABundle\Entity\Region;

class AssignBandsMusicians extends AbstractFixture
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

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;




            try {
                $bands = $this->manager->getRepository('ZE\BABundle\Entity\Band')->findAll();
                $musicians = $this->manager->getRepository('ZE\BABundle\Entity\Musician')->findAll();
                $band = $bands[0];
                $bandMusician = new BandMusician();
                $bandMusician->setBand($band);
                $bandMusician->setMusician($musicians[0]);
                $bandMusician->setStatus(0);
                $this->manager->persist($bandMusician);
                $bandMusician = new BandMusician();
                $bandMusician->setMusician($musicians[1]);
                $bandMusician->setBand($band);
                $bandMusician->setStatus(1);
                $this->manager->persist($bandMusician);
                $this->manager->flush();

            } catch (\Exception $e) {
                echo($e->getMessage());
                $this->manager = $this->container->get('doctrine')->resetManager();
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