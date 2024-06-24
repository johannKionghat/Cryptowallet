<?php

namespace App\Form;

use App\Entity\Wallet;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseWalletType extends AbstractType
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
            ->add('name', EntityType::class,[
                'class' => Wallet::class,
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
                    'class'=>'btn btn-outline-secondary dropdown-toggle',
                     'style'=>'width:100%',
                ]
            ])
            ->add('Change', SubmitType::class, [
                'label'=>'Save',
                'attr'=>[ "class"=>"btn btn-outline-secondary me-2", 'style'=>'width:100%']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
