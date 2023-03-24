<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $artist = new Artist();
            $artist->setName($faker->lastName);
            $manager->persist($artist);
        }

        $manager->flush();
    }
}
