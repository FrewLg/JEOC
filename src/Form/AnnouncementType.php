<?php

namespace App\Form;

use App\Entity\Announcement;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject'  , TextType:: class, [
            'attr'=>['class'=>'form-control col col-md-12 col-sm-12 col-lg-12 ',
                        'placeholder'=>'Subject',
            ],

            ])
            ->add('openAt'  , DateTimeType:: class, [
                'row_attr' => ['class' => 'form-group col-6'],
                "widget"=>"single_text",
                'attr'=>['class'=>'form-control col col-md-12 col-sm-12 col-lg-12 ',
                            'placeholder'=>'Open At',
                ],
    
                ])
                ->add('closeAt'  , DateTimeType:: class, [
                    'row_attr' => ['class' => 'form-group col-6'],
                    "widget"=>"single_text",
                    'attr'=>['class'=>'form-control col col-md-12 col-sm-12 col-lg-12 ',
                    'placeholder'=>'Close At',
                    ],
        
                    ])
            ->add('body',  CKEditorType::class,[
    
  	 'attr'=>['placeholder'=>'Your message ',
   	 'class' => 'form-control',
   	 'required' => false, 
           ],])  
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
