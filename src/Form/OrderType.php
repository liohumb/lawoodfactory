<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
            ->add('addresses', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'form__input-radio'
                ],
                'invalid_message' => "Merci de choisir une adresse de livraison"
            ])
            ->add('carriers', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => Carrier::class,
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'form__input-radio'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
