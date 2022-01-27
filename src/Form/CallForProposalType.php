<?php

namespace App\Form;

use App\Entity\CallForProposal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CallForProposalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('research_type', ResearchType::class)

            ->add('subject',  CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Body of the call',
                    'class' => 'form-control  col col-md-12 col-sm-12 col-lg-9  ',
                    'required' => false,

                ],
            ])
            ->add('heading',  CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Heading title of the call',
                    'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                    'required' => false,

                ],
            ])
            ->add('guidelines',  CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Guideline details',
                    'class' => 'form-control  col col-md-12 col-sm-12 col-lg-9  ',
                    'required' => false,

                ],
            ])
            ->add('deadline', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('funding_source', TextType::class, [
                'attr' => ['class' => 'form-control col col-md-12 col-sm-12 col-lg-9 '],
            ])

            ->add('review_process_start', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('review_process_end', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('reviewers_decision_will_be_communicated_at', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',

            ))
            ->add('project_starts_on', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))


            ->add('number_of_co_pi')
            ->add('allow_non_academic_staff_as_pi')
            // ->add('allow_researcher_from_another_college')
            ->add('allow_pi_from_other_university')
            //->add('commitment_from_other_research', ChoiceType::class,['class'=>'switchery switchery-default'],)
            ->add('commitment_from_other_research', ChoiceType::class, [
                'placeholder' => '-- Select Research Type--',
                'expanded' => true,
                'attr' => [
                    'class' => 'switchery switchery-default  col col-md-12 col-sm-12 col-lg-9  ',
                    'required' => true,

                ],
            ])


            // ->add('work_unit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CallForProposal::class,
        ]);
    }
}
