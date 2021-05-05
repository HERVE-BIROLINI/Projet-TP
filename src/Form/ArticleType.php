<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Title', TextType::class,[
            'label'         =>  "Nom",
            'attr'          =>  ['placeholder'=>"Nom du produit"],
            'required'      =>  true,
        ])
        ->add('Description')    
        ->add('Region')
        ->add('Capacity', TextType::class,[
            'label'         =>  "Contenance",
        ])
        ->add('Price', TextType::class,[
            'label'         =>  "Prix",
        ])
        ->add('Score')
        ->add('Category',EntityType::class,[
            'class' => Category::class,
            'label' => 'Categorie',
            'choice_label' => 'label',
        ])
            // ->add('Image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
