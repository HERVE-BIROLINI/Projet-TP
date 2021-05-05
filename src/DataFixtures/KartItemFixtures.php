<?php

namespace App\DataFixtures;

use App\Entity\KartItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class KartItemFixtures {//extends Fixture implements OrderedFixtureInterface{
    // Pour déclencher LOAD à partir du Terminal
    // bin/console doctrine:fixtures:load
    const KARTITEMS = [
        [
        ],
    ];
    public function _load(ObjectManager $manager)
    {
        foreach (self::KARTITEMS as $Kartitem) {
            $obKartitem = new KartItem(
                // $Article['Label'],
            );
            // $obKart->setLabel($Kart['label']);


            // utiliser AVANT Persist le setReference, 
            // afin de stocker en mémoire les instances des objets 
            // qui dans un second temps (chargement de Article),
            // récupèrera la donnée...
            // $this->setReference($Kartitem['label'],$obKartitem);
            // $this->setReference($Kartitem['key'],$obKartitem);


            // $manager->persist($obKartitem);
        }
        //
        // $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function _getOrder(): int{
        return 4;
    }

}
