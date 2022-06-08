<?php

namespace App\Form;

use App\Entity\Projection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Video;
use App\Entity\Cinema;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ProjectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heureProjection', DateTimeType::class, [
                'date_label' => 'Date de la projection',
            ])
            ->add('video', EntityType::class,[
                'class'=>Video::class,
                'choice_label'=>'titre'
            ])
            ->add('cinema', EntityType::class,[
                'class'=>Cinema::class,
                'choice_label'=>'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projection::class,
        ]);
    }
}
