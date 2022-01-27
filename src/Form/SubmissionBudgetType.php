<?php

namespace App\Form;

use App\Entity\SubmissionBudget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubmissionBudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('cost',NumberType::class,["attr"=>["min"=>"1"],'required'=>true])
            ->add('quantity',IntegerType::class,["attr"=>["min"=>"1"],'required'=>true])
            // ->add('remark')
            // ->add('submission')
            ->add('category' )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubmissionBudget::class,
        ]);
    }
}
