<?php

namespace App\Form;

use App\Entity\Review;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewDecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('remark', ChoiceType::class, [
            'placeholder' => '--Select Editorial decision--',
            'choices' => [
                'Accepted' => 4,
                // 'Accepted with minor revision' =>3, 
                // 'Accepted with major revision' => 2,
                'Declined' => 1,

            ],
            'attr' => [
                'class' => 'form-control',
                'required' => true,
            ],
        ])
        ->add('comment' ,   CKEditorType::class,[
            'attr'=>['placeholder'=>'Comments ',
            'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                         'required' => false,
        
            ],]) 
            

        ->add('attachment', FileType::class, [
            'label' => 'Reviewed document  file',
            'mapped' => false,
            'required' => false,
            'attr' => [
 
                'class' => 'form-control',

                'required' => false,

            ],
        ]) 

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
