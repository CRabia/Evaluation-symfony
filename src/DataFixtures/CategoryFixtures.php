<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create('fr_FR');

        $name = ['Peinture','Dessin','Sculture'];
        for($i = 0; $i < 3;$i++){
            $category = new Category();
            $category->setName($name[$i]);
            $category->setDescription($faker->text);
            $this->addReference($name[$i], $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
