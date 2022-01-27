<?php

namespace App\Form;

use App\Entity\CoAuthor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CoAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('researcher' , EntityType::class, array(
                'required'=>false,
                                      'placeholder' => '-- Select researcher --',
                         'class' => 'App\Entity\User',
                         'attr' => array(
                             'empty' => 'Select User ',
                             'required' => true,
                             'class' => 'form-control select2 chosen-select ',
                         )
                     ))
           ->add('department'
        //    ,null,['attr'=>['class'=>'form-control select2']])
            
           , EntityType::class, array(
            'required'=>false,
                                  'placeholder' => '-- Select Department --',
                     'class' => 'App\Entity\Department',
                     'attr' => array(
                         'empty' => 'Select College ',
                         'required' => true,
                         'class' => 'form-control select2 chosen-select ',
                     )
                 ))

            //  ->add('affiliation' , TextType::class, [
            // 'attr' => [
            //     'placeholder' => 'Affiliation',
            //     'required' => false,
            //     'class'=>'form-control col-md-3',
            // ]])
                    
                                   
        //    ->add('email',EmailType::class)
            ->add('role')
            # ->add('bio')
            #->add('country')
            #->add('url')
#    ->add('last_name') 
 #   ->add('orcid')
    # ->add('position') 
  #    ->add('gender')         
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoAuthor::class,
        ]);
    }
}
