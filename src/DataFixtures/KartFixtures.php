<?php

namespace App\DataFixtures;

use App\Entity\Kart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class KartFixtures {//extends Fixture implements OrderedFixtureInterface{
    // Pour déclencher LOAD à partir du Terminal
    // bin/console doctrine:fixtures:load
    const KARTS = [
        [
        ],
    ];
    public function _load(ObjectManager $manager)
    {
        foreach (self::KARTS as $Kart) {
            $obKart = new Kart(
                // $Article['Label'],
            );
            // $obKart->setLabel($Kart['label']);


            // utiliser AVANT Persist le setReference, 
            // afin de stocker en mémoire les instances des objets 
            // qui dans un second temps (chargement de Article),
            // récupèrera la donnée...
            // $this->setReference($Kart['label'],$obKart);
            // $this->setReference($Kart['key'],$obKart);


            // $manager->persist($obKart);
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
        return 3;
    }

}
