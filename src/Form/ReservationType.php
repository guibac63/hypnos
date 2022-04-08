<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etablissement', EntityType::class,[
                'placeholder' => '--Choix de l\'établissement--',
                'class'=>Etablissement::class,
                'mapped'=>false
            ] )
            ->add('suite',ChoiceType::class,[
                'attr' => ['class' => 'hidden']
            ])
            ->add('beginning_date',DateType::class,[
                'format'=>'dd-MM-yyyy'
            ])
            ->add('ending_date',DateType::class,[
                'format'=>'dd-MM-yyyy'
            ])
//            ->add('client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'allow_extra_fields'=>true
        ]);
    }
}
