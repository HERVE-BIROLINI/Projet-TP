<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
// class AppFixtures extends Fixture
{
    // Pour déclencher LOAD à partir du Terminal
    // bin/console doctrine:fixtures:load
    const CATEGORIES = [
        ['Label'    => "Produit de la ferme",],
        ['Label'    => "Produit de la mer",],
        ['Label'    => "Produit de la terre",],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $Article) {
            $obArticle = new Category(
                // $Article['Label'],
            );
            $obArticle->setLabel($Article['Label']);
            $manager->persist($obArticle);
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
