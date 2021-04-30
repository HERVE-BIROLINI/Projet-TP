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
// Pour déclencher LOAD à partir du Terminal
// bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager){
        foreach (self::USERS as $User) {
            $obUser = new User(
                // $User['email'],
                // $User['roles'],
                // $User['password'],
                // $User['firstname'],
                // $User['lastname'],
                // $User['birthdate'],
                // $User['hasagreetoterms'],
            );
            // $obUser->new \DateTime()
            $obUser->setEmail($User['email']);
            $obUser->setRoles($User['roles']);
            // $obUser->setPassword($User['password']);
            $obUser->setFirstname($User['firstname']);
            $obUser->setLastname($User['lastname']);
            $obUser->setBirthdate($User['birthdate']);
            $obUser->setInscriptiondate (new \DateTime());
            $obUser->setPassword(
                $this->encoder->encodePassword( // ???
                // $passwordEncoder->encodePassword(
                    $obUser,
                    $User['password']
                )
            );
            //
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
        return 3;
    }
}
