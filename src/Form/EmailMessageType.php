<?php

namespace App\Form;

use App\Entity\EmailMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use app\Service\CheckerValidator;//
class EmailMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email_key')
            ->add('subject')
            ->add('body' ,  CKEditorType::class,[
    'attr'=>['placeholder'=>'Describe your reason why',

    'class' => 'form-control',
       
                 'required' => false,
            
],])     
	
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmailMessage::class,
        ]);
    }
}
