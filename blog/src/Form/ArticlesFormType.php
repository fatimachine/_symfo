<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticlesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            // ->add('image',FileType::class,
            // ['label'=> "Photo de l'article",
            // 'mapped'=>true, //signifie que le champ est assuré à une propriété 
            // 'required'=> false, //pour faire sauter le contrôle html (privilégier contrôle symfony)
            // 'constraints'=>
            // new File ([
            //         'maxSize'=> '5M',
            //         'mimeTypes'=> [
            //             'image/jpeg',
            //             'image/jpg',
            //             'image/png',
            //             'image/gif'

            //         ],
            //         'mimeTypesMessage'=> 'Seules les Extensions [jpg/jpeg/png/gif] sont acceptées'
            //     ])
            // ])
            ->add('image')
            ->add('author')
            // ->add('created_at') // ce champ est rempli automatiquement via l'instanciation de la classe Date();
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
