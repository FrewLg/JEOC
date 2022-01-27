<?php

namespace App\Form;

use App\Entity\DirectorateOffice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
class DirectorateOfficeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' ,  TextType::class,[
    
         'attr'=>['placeholder'=>'Your message ',
                'class' => 'form-control col col-md-9 col-sm-9 col-lg-9  ',
         'required' => false, 
           ],])

            ->add('mission',  CKEditorType::class,[
    
  	 'attr'=>['placeholder'=>'Your message ',
   	 'class' => 'form-control  col col-md-9 col-sm-9 col-lg-9 ',
   	 'required' => false, 
           ],])
            ->add('description',  CKEditorType::class,[
    
         'attr'=>['placeholder'=>'Your message ',
         'class' => 'form-control  col col-md-9 col-sm-9 col-lg-9 ',
         'required' => false, 
           ],])

            ->add('contact_address',  CKEditorType::class,[
    
         'attr'=>['placeholder'=>'Your message ',
         'class' => 'form-control  col col-md-9 col-sm-9 col-lg-9 ',
         'required' => false, 
           ],])

            ->add('objective',  CKEditorType::class,[
    
         'attr'=>['placeholder'=>'Your message ',
                'class' => 'form-control col col-md-9 col-sm-9 col-lg-9  ',
         'required' => false, 
           ],])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DirectorateOffice::class,
        ]);
    }
}
