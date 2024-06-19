<?php
// src/Form/SellCryptoType.php

namespace App\Form;

use App\Entity\User;
use App\Entity\Cryptocurrency;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SellCryptoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('cryptocurrency', EntityType::class, [
                'class' => Cryptocurrency::class,
                'choice_label' => 'name',
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount to Sell',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
