<?php

namespace App\Form;

use App\Entity\ResearchReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextareaType::class,[
                "attr"=>[
                  
                    "class"=>"form-control",
                ]
            ])
            ->add('file',FileType::class,[
                "label"=>"Select File",
                "help"=>"Upload research report",
                "mapped"=>false,
                "attr"=>[
                    "accept"=>"application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                    text/plain, application/pdf, image/*",
                    "class"=>"form-control",
                ]
            ])
            ->add('remark',TextareaType::class,[
                "attr"=>[
                  
                    "class"=>"form-control",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResearchReport::class,
        ]);
    }
}
