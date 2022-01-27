<?php

namespace App\Form;

use App\Entity\EditorialDecision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditorialDecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('decision', ChoiceType::class, [
            'placeholder' => 'Select remark',
            'choices' => [

             

                'Accepted' => 4,
                'Accepted with minor revision' =>3, 
                'Accepted with major revision' => 2,
                'Declined' => 1,

            ],
            'attr' => [
                'class' => 'form-control',
                'required' => true,
            ],
        ])
        ->add('feedback', TextareaType::class, array(
            'attr' => array(
                'placeholder' => 'Feedback  for the author',
                'required' => true,
                'class' => 'form-control',
            )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditorialDecision::class,
        ]);
    }
}
