<?php

namespace App\Form;

use App\Entity\WorkUnit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class WorkUnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description',   CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',

    'class' => 'form-control',
       
                 'required' => false,
            
],])     
            ->add('principal_contact' ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',

    'class' => 'form-control',
       
                 'required' => false,
            
],])     

            ->add('identification_code')
             
 ->add('mission',     CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',

    'class' => 'form-control',
       
                 'required' => false,
            
],])     
                        ->add('prefix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkUnit::class,
        ]);
    }
}
