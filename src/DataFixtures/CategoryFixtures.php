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
  
        $this->createMany(count($categoriesNormals), function($num) use($categoriesNormals) {
            $category = (new Category())
                ->setName($categoriesNormals[$num])
                ->setDescription($this->faker->text($maxNbChars = 200))
                ->setTerm('normal');
    
            $this->addReference('categoryNormal-' . $num, $category);

            return $category;
        });

        $this->createMany(count($categoriesSpecials), function($num) use($categoriesSpecials) {
            $category = (new Category())
                ->setName($categoriesSpecials[$num])
                ->setDescription($this->faker->text($maxNbChars = 200))
                ->setTerm('special');
    
            $this->addReference('categorySpecial-' . $num, $category);

            return $category;
        });

        $manager->flush();
    }
}