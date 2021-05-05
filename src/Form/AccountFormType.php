<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // dresse la liste des années à considérer pour la liste de sélection de l'année de naissance...
        $arYears=range(date('Y')-18,date('Y')-95,-1);

        $builder
            ->add('firstname',TextType::class,[
                'label'         =>  "Votre prénom :",
                'attr'          =>  ['placeholder'=>"ex: John"],
                'required'      =>  true,
                'constraints'   =>  [
                    new NotBlank(['message'=>"Le prénom est obligatoire"]),
                ],
            ])
            // 
            ->add('lastname',TextType::class,[
                'label'         =>  "Votre nom de famille :",
                'required'      =>  true,
                'constraints'   =>  [
                    new NotBlank(['message'=>"Le nom est obligatoire"]),
                ],
            ])
            // 
            ->add('birthdate',BirthdayType::class,[
                'label'         =>  "Votre date de naissance :",
                'required'      =>  true,
                // liste des options...
                'years'         =>  $arYears,
                'constraints'   =>  [
                    new NotBlank(['message'=>"La date de naissance est obligatoire"]),
                    // new GreaterThan(['value'=>new DateTime('now')]),
                ],
            ])
            // ADRESSE POSTALE
            ->add('address',TextType::class,[
                'label'         =>  "N° et voie :",
                'attr'          => ['placeholder'   => "ex: 1 avenue des Champs-Elysées",],
                'required'      =>  true,
                'constraints'   =>  [
                    new NotBlank(['message'=>"Le n° et le nom de la voie sont obligatoire"]),
                ],
            ])
            // 
            ->add('postalcode',TextType::class,[
                'label'         =>  "Code postal :",
                'attr'          => ['placeholder'   => "ex: 75008",],
                'required'      =>  true,
                'constraints'   =>  [
                    new NotBlank(['message'=>"Le code postal est obligatoire"]),
                    new Length([
                        'min'       => 5,
                        'max'       => 5,
                        'minMessage'   => 'Un code postal est composé de 5 chiffres',
                        'maxMessage'   => 'Un code postal est composé de 5 chiffres',
                    ]),
                ],
            ])
            // 
            ->add('city',TextType::class,[
                'label'         =>  "Ville :",
                'attr'          => ['placeholder'   => "ex: Paris",],
                'required'      =>  true,
                'constraints'   =>  [
                    new NotBlank(['message'=>"La ville est obligatoire"]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
