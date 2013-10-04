<?php

    namespace Ens\JobeetBundle\DataFixtures\ORM;
    use Bandaid\BandaidUserBundle\Entity\EntityType;
    use Bandaid\BandaidUserBundle\Entity\Genre;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Bandaid\BandaidUserBundle\Entity\Entity;

    class LoadEntitiesData extends AbstractFixture implements OrderedFixtureInterface
    {
        public function load(ObjectManager $em)
        {
            $entityTypeBand = new EntityType();
            $entityTypeBand->setName('band');
            $entityTypeArtist = new EntityType();
            $entityTypeArtist->setName('artist');
            $entityTypeVenue = new EntityType();
            $entityTypeVenue->setName('venue');

            $em->persist($entityTypeBand);
            $em->persist($entityTypeArtist);
            $em->persist($entityTypeVenue);
            $em->flush();

            $this->addReference('entity-type-band', $entityTypeBand);
            $this->addReference('entity-type-artist',$entityTypeArtist);
            $this->addReference('entity-type-venue',$entityTypeVenue);

            $entityExampleBand = new Entity();
            $entityExampleBand->setEntityType($entityTypeBand);
            $entityExampleBand->setDescription('Example Band #1');
            
            $entityExampleArtist = new Entity();
            $entityExampleArtist->setEntityType($entityTypeArtist);
            $entityExampleArtist->setDescription('Example Artist #1');

            $em->persist($entityExampleArtist);
            $em->persist($entityExampleBand);
            $em->flush();

            $genreJazz = new Genre();
            $genreJazz->setGenreName('jazz');

            $entityExampleBand->addGenre($genreJazz);
            $entityExampleArtist->addGenre($genreJazz);
            $em->persist($entityExampleArtist);
            $em->persist($entityExampleBand);
            $em->flush();

        }

        public function getOrder()
        {
            return 1;
        }
    }