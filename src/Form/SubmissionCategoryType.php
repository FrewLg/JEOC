<?php

namespace App\Form;

use App\Utils\Constants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubmissionCategoryType extends AbstractType
{
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "placeholder"=>"Select Submission type",
                "choices"=>[
                    "Mega"=>Constants::RESEARCH_TYPE_MEGA,
                    "Community service"=>Constants::RESEARCH_TYPE_COMMUNITY_SERVICE,
                    "Grant"=>Constants::RESEARCH_TYPE_YOUTH_GRANT,
                    "Technology transfer"=>Constants::RESEARCH_TYPE_TECHNOLOGY_TRANSFER,
                    "Technology transfer"=>Constants::RESEARCH_TYPE_TECHNOLOGY_TRANSFER,
                   
                ]
           
            ]);
        
    }
    public function getParent()
    {
        return ChoiceType::class;
    }
}
