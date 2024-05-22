<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('thumbnailFile', FileType::class,[
                'mapped'=> false,
                'required'=>false,
                'constraints'=>[
                    new Image()
                ],
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('email',EmailType::class,[
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('firstname',TextType::class,[
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('lastname',TextType::class,[
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('countryFrom',ChoiceType::class, [
                'required'=>false,
                'attr'=>["class"=>"form-control"],
                'label'=>false,
                'choices'=>[
                    'Select country'=>'',
                    "Australia"=>'Australia',
                    "Bangladesh"=>'Bangladesh',
                    "Belarus"=>'Belarus',
                    "Brazil"=>'Brazil',
                    "Canada"=>'Canada',
                    "China"=>'China',
                    "France"=>'France',
                    "Germany"=>'Germany',
                    "India"=>'India',
                    "Indonesia"=>'Indonesia',
                    "Israel"=>'Israel',
                    "Italy"=>'Italy',
                    "Japan"=>'Japan',
                    "Korea"=>'Korea, Republic of',
                    "Mexico"=>'Mexico',
                    "Philippines"=>'Philippines',
                    "Russia"=>'Russian Federation',
                    "South Africa"=>'South Africa',
                    "Thailand"=>'Thailand',
                    "Turkey"=>'Turkey',
                    "Ukraine"=>'Ukraine',
                    "United Arab Emirates"=>'United Arab Emirates',
                    "United Kingdom"=>'United Kingdom',
                    "United States"=>'United States',
                ]
            ])
            ->add('cityFrom',TextType::class,[
                'required'=>false,
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('address', TextType::class,[
                'required'=>false,
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('zipcode',NumberType::class,[
                'required'=>false,
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])

            ->add('telephone',NumberType::class,[
                'required'=>false,
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('roles',ChoiceType::class,[
                'choices' => [
                    'admin' => 'admin',
                    'user' =>'user',
                    'Select role' => null,
                ],
                'mapped'=>false,
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('state',ChoiceType::class,[
                'choices' => [
                    'Verified' => true,
                    'No verified' =>false,
                ],
                'mapped'=>false,
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label'=>'Save',
                'attr'=>[ "class"=>"btn btn-primary me-2"]
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
