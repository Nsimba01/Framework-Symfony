<?php

namespace App\DataFixtures;

use App\Entity\Atelier;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


use Faker\Factory;

use Faker\Generator;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
		
		 // on crée 4 Ateliers avec noms et description"aléatoires" 
		 
		 
         $ateliers = Array();
		 
		 
		  for ($i = 0; $i < 4; $i++) {
               $ateliers[$i] = new Atelier();
               $ateliers[$i]->setNom($faker->word()); //  Remplissage aléatoire de Nom attribut d' Atelier
               $ateliers[$i]->setDescription($faker->sentence()); // Remplissage aléatoire de Description attribut  d'Attelier

               $manager->persist($ateliers[$i]);
           }
		
		// $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
