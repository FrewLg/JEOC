<?php

namespace App\Form;

use App\Entity\BudgetRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
           ->add('description')
            #->add('submission')
#            ->add('expenses', CollectionType::class, [
 #           'entry_type' => ExpenseType::class,
  #          'entry_options' => ['label' => false],
   #     ])
        ->add('expenses', CollectionType::class, [
        'entry_type' => ExpenseType::class,
        'entry_options' => ['label' => false],
        'allow_add' => true,
    ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BudgetRequest::class,
        ]);
    }
}
