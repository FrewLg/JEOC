<?php

namespace App\Form;

use App\Entity\UserFeedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('sent_at')
            ->add('subject' ,TextType::class,
            [
'attr'=>[
                    'class' => 'form-control col col-md-3',
                    'required'=>true,
]
            ])


            ->add('the_feedback' ,TextareaType::class,
            [
                'label'=>'Message',
'attr'=>[
                    'class' => 'form-control col col-md-3',
                    'required'=>true,
]
            ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserFeedback::class,
        ]);
    }
}
