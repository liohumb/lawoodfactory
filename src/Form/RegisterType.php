<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('lastname', TextType::class, [
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
                'label' => 'Votre adresse em@il',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('cguv', CheckboxType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form__input-check'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
