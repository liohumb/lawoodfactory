<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'votre@email.com',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Votre ville',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Dites nous tout...',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
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
