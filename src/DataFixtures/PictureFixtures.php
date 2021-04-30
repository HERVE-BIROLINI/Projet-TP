<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PictureFixtures extends Fixture implements OrderedFixtureInterface{

    const PICTURES = [
        ['pathname' => "...", // juste le nom (??? pour tester déjà)
        ],
        // ....
    ];
// Pour déclencher LOAD à partir du Terminal
// bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager){
        foreach (self::PICTURES as $Picture) {
            $obPicture = new Picture(
                // $Picture['pathname'],
            );
            // $obPicture->
            $obPicture->setPathname($Picture['pathname']);
            $manager->persist($obPicture);
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
        return 2;
    }
}
