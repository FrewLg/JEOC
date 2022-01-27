<?php

namespace App\Form;

use App\Entity\InstitutionalReviewersBoard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutionalReviewersBoardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('specialization')
            ->add('affiliation')
            ->add('workunit')
            ->add('name')
            ->add('reviewer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstitutionalReviewersBoard::class,
        ]);
    }
}
