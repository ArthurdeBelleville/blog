<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      
      $faker = \Faker\Factory::create('fr_FR');

     for($i = 1; $i <= 3; $i++)
     {
       $category = new Category;

       $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());


                $manager->persist($category);

     }
    

    }
}

