<?php

namespace App\Form;

use App\Entity\Cryptocurrency;
use App\Entity\Wallet;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CryptoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name',TextType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('CurrentPrice',NumberType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('imageFile',FileType::class,[
                'mapped'=>false,
                'label'=>false,
                'constraints'=>[
                    new Image()
                ],
                'required'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('Abreviation',TextType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label'=>'Save',
                'attr'=>[ "class"=>"btn btn-primary me-2"]
            ])
//             ->add('soldeCrypto')
//             ->add('IdWallet', EntityType::class, [
//                 'class' => Wallet::class,
// 'choice_label' => 'id',
//             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cryptocurrency::class,
        ]);
    }
}
