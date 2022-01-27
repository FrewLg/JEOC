<?php

namespace App\Form;

use App\Entity\PublishedResearch;
use App\Entity\PublishedTopic;
use App\Entity\Submission; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PublishedResearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('title'  ,EntityType::class,[
                'placeholder' => '---Select title---',
             
                "class"=>PublishedTopic::class,
                "attr"=>[
                    "class"=>"select2 col-lg-2 col-sm-4 col-md-2",
                ]
            ])  
            ->add('allotted_budget')
            ->add('year'  )
                      
            // ->add('remark')
            ->add('successfully_completed')
            // ->add('final_report') 
            // ->add('irb_clearance', FileType::class, [
            //     'label' => 'IRB clearance document  file',
            //     'mapped' => false,
            //     'required' => false,
            //     'attr' => [ 
            //         'class' => 'form-control',
    
            //         'required' => false,
    
            //     ],
            // ])

        //     ->add('imageFile'  ,VichFileType::class,[
        //         'allow_delete' => false,
        //         // 'allow_add' => true,
        //         // 'data_class' => null,                
        //         // 'delete_label' => 'Remove file',
        //    //     'download_uri' => '...',
        //        'download_label' => 'Download file',
        //     ])
            // ->add('user')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublishedResearch::class,
        ]);
    }
}
