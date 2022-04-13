<?php

namespace App\Form;

use App\Validator\UniqueHoneyMail;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class,[
                'constraints'=>[new NotBlank(['message'=>'Merci de saisir un prénom'])]
            ])
            ->add('lastname',TextType::class,[
                'constraints'=>[new NotBlank(['message'=>'Merci de saisir un nom'])]
            ])
            ->add('email',EmailType::class,[
                'required'=>false
            ])
            ->add('hpt200', EmailType::class,[
                'required' => true,
            ])
            ->add('subject',ChoiceType::class,[
                'choices'=>[
                    'Poser une réclamation'=>'reclamation',
                    'Service supplémentaire'=>'service',
                    "En savoir plus sur une suite"=>'info',
                    'Souci avec l\'application'=>'probleme'
                ]
            ])
            ->add('message',TextareaType::class,[
                'constraints'=>[new NotBlank(['message'=>'Vous devez saisir un message'])],
            ])
            ->add('conditions',CheckboxType::class,[
                'constraints'=>[new NotBlank(['message'=>'Merci de cocher la case'])]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
