<?php

namespace App\DataFixtures;

use App\Entity\ArtWork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ArtWorkFixtures extends Fixture implements OrderedFixtureInterface
{
    public $categories = ['Peinture','Dessin','Sculture'];

    public function load(ObjectManager $manager)
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $artwork = new Artwork();
            $name =$faker->word;
            $artwork->setName(ucfirst($name));
            $artwork->setDescription($faker->text);
            $artwork->setSlug($name);
            $artwork->setPicture($faker->image('public/img/artwork', 800, 450, null, false));

            $randomCategoryIndex = random_int(0, count($this->categories) - 1);
            $category = $this->categories[$randomCategoryIndex];
            $artwork->setCategory($this->getReference($category));

            $manager->persist($artwork);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
