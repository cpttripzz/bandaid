<?php

    namespace  Bandaid\BandaidUserBundle\DataFixtures\ORM;
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

            
            $entityExampleBand1 = new Entity();
            $entityExampleBand1->setEntityType($entityTypeBand);
            $entityExampleBand1->setDescription('The Schmoozy Schmazz Band');

            $entityExampleBand2 = new Entity();
            $entityExampleBand2->setEntityType($entityTypeBand);
            $entityExampleBand2->setDescription('Rotten Dripping Demon Entrails');

            
            $entityExampleArtist1 = new Entity();
            $entityExampleArtist1->setEntityType($entityTypeArtist);
            $entityExampleArtist1->setDescription('Schmoozy Schmazz');

            $entityExampleArtist2 = new Entity();
            $entityExampleArtist2->setEntityType($entityTypeArtist);
            $entityExampleArtist2->setDescription('Jimmy Jitters');

            $entityExampleArtist3 = new Entity();
            $entityExampleArtist3->setEntityType($entityTypeArtist);
            $entityExampleArtist3->setDescription('Bloozy Blowz');

            $entityExampleArtist4 = new Entity();
            $entityExampleArtist4->setEntityType($entityTypeArtist);
            $entityExampleArtist4->setDescription('Dagth the Abominable');


            $em->persist($entityExampleArtist1);
            $em->persist($entityExampleArtist2);
            $em->persist($entityExampleArtist3);
            $em->persist($entityExampleArtist4);
            $em->persist($entityExampleBand1);
            $em->persist($entityExampleBand2);
            $em->flush();

            $genreJazz = new Genre();
            $genreJazz->setGenreName('jazz');
            
            $genreDeathMetal = new Genre();
            $genreDeathMetal->setGenreName('Death Metal');

            $entityExampleBand1->addGenre($genreJazz);
            $entityExampleBand2->addGenre($genreDeathMetal);

            $entityExampleArtist1->addGenre($genreJazz);
            $entityExampleArtist2->addGenre($genreJazz);
            $entityExampleArtist3->addGenre($genreJazz);
            $entityExampleArtist4->addGenre($genreDeathMetal);
            
            
            $em->persist($entityExampleArtist1);
            $em->persist($entityExampleArtist2);
            $em->persist($entityExampleArtist3);
            $em->persist($entityExampleArtist4);
            $em->persist($entityExampleBand1);
            $em->persist($entityExampleBand2);

            $em->flush();

        }

        public function getOrder()
        {
            return 1;
        }
    }