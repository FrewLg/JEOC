<?php

namespace App\Form;

use App\Entity\ResearchReportPhase;
use App\Entity\ResearchReportSubmissionSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchReportSubmissionSettingType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
          for ($i=1; $i <= $options['researchReportPhase']?->getNumberOfPhases(); $i++) { 
            

           
       
        $builder
            
            ->add('submissionDate_'.$i,TextType::class,[
                "label"=>"Starts on",
               "mapped"=>false,
              
             
               
              "attr"=>[
                   // "min"=>(new \DateTime())->format("Y-m-d H:i:s"),
                   "class"=>"js-datepicker input_submission_date",
                   "autocomplete"=>"off"
               ]
           ])
        ;
              }
          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResearchReportSubmissionSetting::class,
            'researchReportPhase' => null,
        ]);
    }
}
