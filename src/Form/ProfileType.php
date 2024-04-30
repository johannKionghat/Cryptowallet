<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('language', ChoiceType::class,[ 
                'required'=>false,
                'attr'=>["class"=>"form-control"],
                'label'=>false,
                'choices'=>[
                    'Select language'=>'',
                    'English'=>"en",
                    'French'=>"fr",
                    'German'=>"de",
                    'Portuguese'=>"pt"
                ]
            ])
            ->add('telephone',NumberType::class,[
                'required'=>false,
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('currency', ChoiceType::class, [
                'required'=>false,
                'choices'=>[
                    'Select Currency'=>"",
                    'USD'=>"usd",  
                    'Euro'=>"euro",   
                    'Pound'=>"pound",  
                    'Bitcoin'=>"bitcoin"
                ],
                'attr'=>["class"=>"form-control"],
                'label'=>false,
            ])
            ->add('save', SubmitType::class, [
                'label'=>'Save changes',
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
