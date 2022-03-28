<?php

namespace App\Form;

use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Le nom',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'La description',
                'attr' => [
                    'class' => 'form__input',
                    'placeholder' => ' '
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'Le prix',
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
            'data_class' => Carrier::class,
        ]);
    }
}
