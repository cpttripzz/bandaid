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
use Faker;
use ZE\BABundle\Entity\Address;
use ZE\BABundle\Entity\Band;
use ZE\BABundle\Entity\Item;
use ZE\BABundle\Entity\Musician;
use ZE\BABundle\Entity\Region;

class LoadUserData extends AbstractFixture
    implements OrderedFixtureInterface,
    FixtureInterface,
    ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $cities;
    private $genres;
    private $faker;
    private  $manager;
    private $instruments;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getRandomGenre()
    {
        return $this->genres[rand(0, count($this->genres) - 1)];
    }

    public function getRandomInstrument()
    {
        return $this->instruments[rand(0, count($this->instruments) - 1)];
    }

    public function createRandomAddress()
    {
        $city = $this->cities[rand(0, count($this->cities) - 1)];
        $client = $this->container->get('jcroll_foursquare_client');

        $command = $client->getCommand('venues/explore', array(
            'll' => $city->getLatitude() . ',' . $city->getLongitude()
        ));
        $results = $command->execute();

        if (!empty($results['meta']['code']) && $results['meta']['code'] == 200) {
            if (empty($results['response']['groups'][0]['items'])) {
                return false;
            }
            foreach ($results['response']['groups'][0]['items'] as $item) {
                if (empty($item['venue']['location']['address'])) {
                    continue;
                }
                $stamItem = $this->manager->getRepository('ZE\BABundle\Entity\Item')->findOneByFsId($item['venue']['id']);
                if ($stamItem) {
                    continue;
                }
                $stamItem = new Item();
                $stamItem->setFsId($item['venue']['id']);

                $address = new Address();
                $address->setCity($city);
                $address->setAddress($item['venue']['location']['address']);
                if (!empty($item['venue']['location']['lat']) && !empty($item['venue']['location']['lng'])) {
                    $address->setLatitude($item['venue']['location']['lat']);
                    $address->setLongitude($item['venue']['location']['lng']);
                }
                $region = $this->getOrCreateRegion($city);
                if ($region) {
                    $address->setRegion($region);
                }
                $this->manager->persist($stamItem);
                $this->manager->persist($address);
                return $address;
            }
        }
    }

    public function getOrCreateRegion($city)
    {

        $cityName = $city->getName() . ', ' . $city->getCountry()->getName();
        $geo = $this->container->get('google_geolocation.geolocation_api');
        $location = $geo->locateAddress($cityName);
        $result = json_decode($location->getResult(), true);

        foreach ($result[0]['address_components'] as $addressComponent) {
            if (!isset($addressComponent['types'][0])) {
                return false;
            }
            $type = $addressComponent['types'][0];
            if ($type == 'administrative_area_level_1') {
                $regionShortName = $addressComponent['short_name'];
                $regionLongName = $addressComponent['long_name'];

                $region = $this->manager->getRepository('ZE\BABundle\Entity\Region')->findOneByLongName($regionLongName);
                if (!$region) {
                    $region = new Region();
                    $region->setCountry($city->getCountry());
                    $region->setShortName($regionShortName);
                    $region->setLongName($regionLongName);
                    $this->manager->persist($region);
                }
                return $region;
            }

        }
    }


    public function createRandomBand()
    {
        $band = new Band();
        $band->setName($this->faker->sentence($nbWords = rand(1, 5)));
        $band->setDescription($this->faker->text($maxNbChars = 200));
        for ($i = 0; $i < rand(1, 3); $i++) {
            $band->addGenre($this->getRandomGenre());
        }
        for ($i = 0; $i < rand(1, 2); $i++) {
            $band->addAddress($this->createRandomAddress());
        }
        $this->manager->persist($band);
        return $band;
    }

    public function createRandomMusician()
    {
        $musician = new Musician();
        $musician->setName($this->faker->sentence($nbWords = rand(1, 5)));
        $musician->setDescription($this->faker->text($maxNbChars = 200));

        for ($i = 0; $i < rand(1, 3); $i++) {
            $musician->addGenre($this->getRandomGenre());
        }
        for ($i = 0; $i < rand(1, 2); $i++) {
            $musician->addAddress($this->createRandomAddress());
        }
        for ($i = 0; $i < rand(1, 2); $i++) {
            $musician->addInstrument($this->getRandomInstrument());
        }
        $this->manager->persist($musician);
        return $musician;
    }


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager  $manager)
    {

        $userManager = $this->container->get('fos_user.user_manager');
        $groupManager = $this->container->get('fos_user.group_manager');
        $userGroup = $groupManager->findGroupByName('user');
        if (!$userGroup) {
            $userGroup = $groupManager->createGroup('user');
            $groupManager->updateGroup($userGroup, true);
        }
        $this->faker = Faker\Factory::create();
        $this->manager =  $manager;
        $this->cities =  $this->manager->getRepository('ZE\BABundle\Entity\City')->findAll();
        $this->genres =  $this->manager->getRepository('ZE\BABundle\Entity\Genre')->findAll();
        $this->instruments =  $this->manager->getRepository('ZE\BABundle\Entity\Instrument')->findAll();
       

        for ($x = 0; $x < 10; $x++) {
            try {
                $user = $userManager->createUser();
                $user->setUsername($this->faker->userName);
                $user->setEmail($this->faker->email);
                $user->setPlainPassword('123456');

                $user->setDateOfBirth($this->faker->dateTimeBetween($startDate = '-80 years', $endDate = '-20 years'));
                $user->setFirstname($this->faker->firstName);
                $user->setLastname($this->faker->lastName);
                $gender = (rand(0, 1) == 1 ? 'm' : 'f');
                $user->setGender($gender);
                $user->setPhone($this->faker->phoneNumber);
                $user->addGroup($userGroup);
                $user->setEnabled(true);
                $user ->setRoles(array('ROLE_USER'));

                $randomAssociation = rand(1, 100);
                if ($randomAssociation > 90 || $randomAssociation > 50) {
                    for ($j = 0; $j < rand(1, 2); $j++) {
                        $band = $this->createRandomBand();
                        $user->addBand($band);
                        $band->setUser($user);
                    }
                }

                if ($randomAssociation > 90 || $randomAssociation < 50) {
                    for ($j = 0; $j < rand(1, 2); $j++) {
                        $musician = $this->createRandomMusician();
                        $user->addMusician($musician);
                        $musician->setUser($user);
                    }
                }
                $userManager->updateUser($user, true);
                 $this->manager->flush();
                echo("\n user created:" . $user->getUsername());
            } catch (\Exception $e) {
                echo ($e->getMessage());
                $this->manager = $this->container->get('doctrine')->resetManager();
                continue;
            }
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