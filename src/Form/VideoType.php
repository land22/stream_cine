<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'serie'=>'serie',
                    'film'=>'film'
                ]
            ])
            ->add('acteur')
            ->add('realisateur')
            ->add('url')
            ->add('image',FileType::class,[
                'label' => 'Image mise en avant',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Veuillez soumettre un fichier valide',
                    ])
                ],
            ])
            ->add('categorie', EntityType::class,[
                'class'=>Categorie::class,
                'choice_label'=>'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
