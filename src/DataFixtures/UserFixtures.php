<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface{

    const USERS = [
        ['email'            => "birolini.herve@gmail.com",
        'roles'             => ["ROLE_ADMIN"],
        'password'          => "Achanger2021",
        'firstname'         => "herve",
        'lastname'          => "birolini",
        'birthdate'         => "1972-05-16",
        'hasagreetoterms'   => 1,
        ],
        ['email'            => "john.doe@hotmail.ru",
        'roles'             => ["ROLE_USER"],
        'password'          => "Achanger2021",
        'firstname'         => "john",
        'lastname'          => "doe",
        'birthdate'         => "1950-07-01",
        'hasagreetoterms'   => 1,
        ],
        // ....
    ];

    // /!\ INDISPENSABLE POUR HASHER LE MOT DE PASSE DANS LOAD /!\
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

// Pour déclencher LOAD à partir du Terminal
// bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager){
        foreach (self::USERS as $Item) {
            $obUser = new User(
                // ex : mauvaise méthode :
                // $Item['email'],
                // $Item['roles'],
            );
            // $obUser->new \DateTime()
            $obUser->setEmail($Item['email']);
            $obUser->setRoles($Item['roles']);
            // $obUser->setPassword($Item['password']);
            $obUser->setFirstname($Item['firstname']);
            $obUser->setLastname($Item['lastname']);
            $obUser->setBirthdate(new \DateTime($Item['birthdate']));
            $obUser->setInscriptiondate(new \DateTime());
            $obUser->setHasagreetoterms($Item['hasagreetoterms']);
            //
            $obUser->setPassword(
                $this->encoder->encodePassword(
                    $obUser,
                    $Item['password']
                )
            );
            //

// utiliser AVANT Persist le setReference, 
// afin de stocker en mémoire les instances des objets 
// $this->setReference($Item['email'],$obUser);

            ///
            $manager->persist($obUser);
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
