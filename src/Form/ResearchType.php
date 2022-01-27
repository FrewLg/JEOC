<?php

namespace App\Form;

use App\Utils\Constants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchType extends AbstractType
{
   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'placeholder' => '-- Select Research Type--',
            'attr' => [
                'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                'required' => true,

            ],
            'choices' => [
                'University Research' => [
                    'Mega research' => Constants::RESEARCH_TYPE_MEGA,
                    'Community service' => Constants::RESEARCH_TYPE_COMMUNITY_SERVICE,
                    'Technology transfer' => Constants::RESEARCH_TYPE_TECHNOLOGY_TRANSFER,
                    'Female granted' => Constants::RESEARCH_TYPE_FEMALE_GRANT,
                    'Youth granted' => Constants::RESEARCH_TYPE_YOUTH_GRANT,
                    'PG Students' => Constants::RESEARCH_TYPE_PG_STUDENT,
                ],
              

            ],
        ]);
    }
   
    public function getParent()
    {
  return ChoiceType::class;
    }
}
