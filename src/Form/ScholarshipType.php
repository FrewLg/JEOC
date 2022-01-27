<?php

namespace App\Form;

use App\Entity\Scholarship;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ScholarshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('url')
            // ->add('created_at')
            ->add('country')
            ->add('description' ,  CKEditorType::class,[
                    'attr'=>['placeholder'=>'Describe your reason why',
                
                    'class' => 'form-control',
                       
                                 'required' => false,
                            
                ],])    
            ->add('deadline' , DateType::class, array(
                            'placeholder' => [
                  'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                          'widget' => 'single_text',
                          'format' => 'yyyy-MM-dd',
                             'attr' => array(
                
                       'required' => true,
                'class'=>'form-group col-md-4',
                   )              
                      )) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Scholarship::class,
        ]);
    }
}
