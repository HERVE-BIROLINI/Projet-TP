<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'attr'          =>  ['placeholder'=>"Nom de l'article à créer"],
                'required'      =>  true,
            ])
            ->add('Description', TextType::class,[
                'label'         =>  "Description",
                'attr'          =>  ['placeholder'=>"Description de l'article"],
                'required'      =>  true,
            ])    
            ->add('Region', TextType::class,[
                'label'         =>  "Région",
                'attr'          =>  ['placeholder'=>"Provenance de l'article"],
                'required'      =>  true,
            ])
            ->add('Capacity', TextType::class,[
                'label'         =>  "Contenance",
                'attr'          =>  ['placeholder'=>"Volume/Poids du contenant"],
                'required'      =>  true,
            ])
            ->add('Price', TextType::class,[
                'label'         =>  "Prix",
                'attr'          =>  ['placeholder'=>"Prix de vente"],
                'required'      =>  true,
            ])
            ->add('Score', TextType::class,[
                'label'         =>  "Région",
                'attr'          =>  ['placeholder'=>"Provenance de l'article"],
                'required'      =>  true,
            ])
            ->add('Category',EntityType::class,[
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_label' => 'label',
            ])
            ->add('Bestseller',CheckboxType::class,[
                'label' => 'Bestseller',
                'required'      =>  false,
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
