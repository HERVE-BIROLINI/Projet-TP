<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface{
    // Pour déclencher LOAD à partir du Terminal
    // bin/console doctrine:fixtures:load
    const CATEGORIES = [
        [
            // 'key' => "charcut",
            'label'    => "Charcuterie"
        ],
        [
            // 'key' => "mer",
            'label'    => "Produit de la mer"
        ],
        [
            // 'key' => "mer",
            'label'    => "Luxe"
        ],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $Category) {
            $obCategory = new Category(
                // $Article['Label'],
            );
            $obCategory->setLabel($Category['label']);


            // utiliser AVANT Persist le setReference, 
            // afin de stocker en mémoire les instances des objets 
            // qui dans un second temps (chargement de Article),
            // récupèrera la donnée...
            $this->setReference($Category['label'],$obCategory);
            // $this->setReference($Category['key'],$obCategory);


            $manager->persist($obCategory);
        }
        //
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int{
        return 1;
    }

}
