<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Repository\ArtistRepository;
use App\Repository\CityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EventFixtures extends Fixture
{
    private $artistRepository, $cityRepository;

    public function __construct(ArtistRepository $artistRepository, CityRepository $cityRepository)
    {
        $this->artistRepository = $artistRepository;
        $this->cityRepository = $cityRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $artists = $this->artistRepository->findAll();
        $cities = $this->cityRepository->findAll();

        for ($i = 0; $i < 100; $i++) {
            $randomArtist = $faker->randomDigitNot(count($artists));
            $randomCity = $faker->randomDigitNot(count($cities));

            $event = new Event();
            $event->setArtist($artists[$randomArtist])
                ->setCity($cities[$randomCity])
                ->setDate($faker->dateTimeBetween($startDate = 'now', $endDate = '+2 year'));

            $manager->persist($event);
        }



        $manager->flush();
    }

    /**
     * @return list<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [City::class, Artist::class];
    }
}
