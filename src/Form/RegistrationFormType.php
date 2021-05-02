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

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // dresse la liste des années à considérer pour la liste de sélection de l'année de naissance...
        $arYears=range(date('Y')-18,date('Y')-95,-1);
        // rsort($arYears);

        $builder
            // 
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
                'attr'          =>  ['placeholder'=>"ex: Doe"],
                'required'      =>  true,
                'constraints'   =>  [
                    new NotBlank(['message'=>"Le nom est obligatoire"]),
                ],
            ])
            //
            ->add('email',EmailType::class,[
                'label' =>  "Votre adresse eMail :",
                'attr'  =>  ['placeholder'=>"ex: mon@email.fr"],
                // ICI surcharge des sécurités côté FRONT pour :
                //  1. guider l'utilisateur (UX)
                //  2. limiter les aller/retours avec le serveur
                'required'      =>  true,
                'constraints'   =>  [
                    new NotBlank(['message' =>  "L'adresse eMail est obligatoire"]),
                    new Email   (['message' =>  "L'adresse eMail n'est pas valide"]),
                    // new Unique  (['message' =>  "Un compte utilisant cet email existe déjà"]),
                ],
            ])
            // 
            ->add('birthdate',BirthdayType::class,[
                'label'         =>  "Votre date de naissance :",
                'required'      =>  true,
                // pseudo placeholder pris en charge par Symfony pour les Select !
                'placeholder'   =>  ['year'=>"Année",
                                    'month'=>"Mois",
                                    'day'=>"Jour",
                ],
                // liste des options...
                'years'         =>  $arYears,
                'constraints'   =>  [
                    new NotBlank(['message'=>"La date de naissance est obligatoire"]),
                    // new GreaterThan(['value'=>new DateTime('now')]),
                ],
            ])
            // 
            ->add('plainPassword', RepeatedType::class, [
                'type'      => PasswordType::class,
                'mapped'    => false,
                'required'  =>  true,
                //
                'first_options' => [
                    'label' => false,// 'label' => "Mot de passe",
                    'attr'  => ['placeholder'   => "Saisir votre mot de passe",],
                    'constraints'   => [
                        new NotBlank(['message' => 'Please enter a password',]),
                        new Length([
                            'min'           => 6,
                            'minMessage'    => 'Your password should be at least {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max'           => 4096,
                        ]),
                        new Regex([
                            'pattern'   => "@^[a-z0-9]+@i",
                            'message'   => "Doit contenir des caractères alphanumériques",
                        ])
                    ],
                ],
                'second_options' => [
                    // 'label' => "Confirmez le mot de passe :",
                    'label' => false,
                    'attr'  => ['placeholder'   => "Confirmer votre mot de passe",],
                ],
                // message si les champs ne correspondent pas
                'invalid_message'   => "Les mots de passe ne sont pas identiques..."
            ])
            // 
            ->add('hasagreetoterms', CheckboxType::class, [
                'label' => "J'accepte Les conditions d'utilisation",
                // ->add('agreeTerms', CheckboxType::class, [
                // 'mapped'        => false,
                'required'      =>  true,
                'constraints'   => [
                    new IsTrue([
                        'message'   => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
