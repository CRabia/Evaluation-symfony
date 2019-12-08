<?php

namespace App\DataFixtures;

use App\Entity\Exposition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker\Factory as Faker;

class ExpositionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $exposition = new Exposition();

            $exposition->setName(ucfirst($faker->word));
            $exposition->setDescription($faker->text);
            $exposition->setDate($faker->dateTimeBetween("-3 days",'now',null));
            $manager->persist($exposition);
        }
        $manager->flush();
    }
}
