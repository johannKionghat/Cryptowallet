<?php

namespace App\Form;

use App\Entity\Cryptocurrency;
use App\Entity\Wallet;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionStep1 extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('cryptos', EntityType::class,[
                'mapped'=>false,
                'required'=>true,
                'label'=>false,
                'class'=> Cryptocurrency::class,
                'choice_label'=> function(Cryptocurrency $cryptocurrency){
                    return $cryptocurrency->getName();
                },
                'attr'=>[
                    'class'=>'form-control dropdown-toggle'
                ]
            ])
            ->add('wallets', EntityType::class,[
                'class' => Wallet::class,
                'mapped'=>false,
                'label'=>false,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('w')
                        ->where('w.IdUser = :user')
                        ->setParameter('user', $user);
                },
                'choice_label'=>function (Wallet $wallet): string{
                    return $wallet->getName();
                },
                'attr'=>[
                    'class'=>'form-control dropdown-toggle',
                ]
            ])
            ->add('Next',SubmitType::class,[
                'attr'=>['class'=>'btn btn-primary']
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
