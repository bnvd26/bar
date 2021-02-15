<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Country;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // catégories normals
        $categoriesNormals = ['blonde', 'brune', 'blanche'];

        // catégories specials
        $categoriesSpecials = ['houblon', 'rose', 'menthe', 'grenadine', 'réglisse', 'marron', 'whisky', 'bio'];
        
        $c = 0;
        
        for ($i=0; $i < count($categoriesNormals); $i++) { 
            
            for ($y=0; $y < count($categoriesSpecials); $y++) { 
                
                $category = (new Category())
                ->setName($categoriesNormals[$i])
                ->setDescription($this->faker->text($maxNbChars = 200))
                ->setTerm($categoriesSpecials[$i]);
    
                $this->addReference('category-' . $c, $category);

                $manager->persist($category);

                $c++;
            }
        }

        $manager->flush();
    }
}