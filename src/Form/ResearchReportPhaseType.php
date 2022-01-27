<?php

namespace App\Form;

use App\Entity\ResearchReportPhase;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchReportPhaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder
            ->add('numberOfPhases',ChoiceType::class,[

                "choices"=>array_combine(range(2,10),range(2,10)),
                "help"=>"Total number of phases",
                "attr"=>[
                    "min"=>1,
                ]
            ])
            ->add('maximumDuration',IntegerType::class,[
                "help"=>"minimum days after last report ",
                "label"=>"minimum days after last report(days)",
                "attr"=>[
                    "min"=>1,
                ]
            ])
            ->add('tolerableDay',ChoiceType::class,[

                "choices"=>array_combine(range(1,10),range(1,10)),
                "help"=>"Tolerable Days",
                "attr"=>[
                    "min"=>1,
                ]
            ])
            ->add('startDate',TextType::class,[
                 "label"=>"Starts on",
                "mapped"=>false,
                
                
                "attr"=>[
                    "value"=>$options['data']?->getStartDate()->format('Y/m/d H:i'),
                    // "min"=>(new \DateTime())->format("Y-m-d H:i:s"),
                    "placeholder"=> "Select Start date" ,
                    "class"=>"js-datepicker"
                ]
            ])
            ->add('endDate',TextType::class,[
                "label"=>"End Date",
              "mapped"=>false,
              
             
              
              "attr"=>[
                "value"=>$options['data']?->getEndDate()->format('Y/m/d H:i'),
                   
                  "placeholder"=>
                  "Select Start date",
                    // "min"=>(new \DateTime())->format("Y-m-d H:i:s"),
                    "class"=>"js-datepicker",
                    "autocomplete"=>"off"
                ]
           ])
           ->add('note',TextareaType::class,[

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResearchReportPhase::class,
        ]);
    }
}
