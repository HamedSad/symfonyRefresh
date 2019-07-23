<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProjectFixture extends Fixture
{
    public function load(ObjectManager $manager)


    {
        //Création de 100 nouveaux projets php binconsole make:fixture
        // $product = new Product();
        // $manager->persist($product);

        //composer require fzaniotto/faker
        $faker = Factory::create('fr_FR');
        for($i = 0; $i<100; $i++){
            $project = new Project();
            //utilisation de la librairie faker pour générer du texte dynaiquement
            $project 
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(2, 40))
                ->setArea($faker->numberBetween(2, 40))
                ->setGround($faker->numberBetween(0, count(Project::GROUND) - 1))
                ->setUser($faker->numberBetween(1, 40));
            $manager->persist($project);
        }

        $manager->flush();
    }
}
