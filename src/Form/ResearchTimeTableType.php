<?php

namespace App\Form;

use App\Entity\ResearchTimeTable; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;


class ResearchTimeTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('task')
            ->add('date_start'   , DateType::class, array(
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
            ->add('date_end'  , DateType::class, array(
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
            ->add('remark')
            // ->add('is_accomplished')
            // ->add('submission')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResearchTimeTable::class,
        ]);
    }
}
