<?php

namespace App\Form;

use App\Entity\Submission;
use App\Entity\ThematicArea;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubmissionFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
        $builder
            ->add('abstract',TextType::class,[
                
            ])


            ->add('title',TextType::class,[
             
            ])
            ->add('sentAt', TextType::class, [
                "required" => false,
                "attr"=>[
                    "class"=>"daterangerpicker",
                    "autocomplete"=>"off"
                ]
            ])
         
            ->add('complete', ChoiceType::class, [
                "placeholder"=>"Select Completion status",
                "choices" => [
                    
                    "Completed" => 1,
                    "In progress" => 0,
                ]
            ])
            ->add('submission_type',SubmissionCategoryType::class)
            ->add('funding_organization')
            ->add('reference')
            ->add('project_start_at',TextType::class,[
                "attr"=>[
                    "class"=>"daterangerpicker",
                    "autocomplete"=>"off"
                ]
            ])
            ->add('project_end_at',TextType::class,[
                "attr"=>[
                    "class"=>"daterangerpicker",
                    "autocomplete"=>"off"
                ]
            ])
            ->add('progress')
            ->add('published', ChoiceType::class, [
                "placeholder"=>"Select Publication status",
               
                "choices" => [
                    "Published" => 1,
                    "not Published" => 0,
                ]
            ])
            //->add('status')
            ->add('keywords')
            ->add('methodology')
            ->add('author',EntityType::class,[
                "class"=>User::class,
                "multiple"=>true,
                "attr"=>[
                    "class"=>"select2"
                ],
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                    ->join("u.submissions","s","With","s.author=u.id")
                       ;
                }
            ])
            ->add('coAuthor',EntityType::class,[
                "class"=>User::class,
                "multiple"=>true,
                "attr"=>[
                    "class"=>"select2"
                ],
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                    ->join("u.coAuthors","c","With","c.researcher=u.id")
                    ->join("c.submission","s","With","s.id=c.submission")
                       ;
                }
            ])
            ->add('thematic_area', EntityType::class, [
                "placeholder"=>"Select Thematic area",
                "attr"=>[
                    "class"=>"select2"
                ],
                "class" => ThematicArea::class,
                "required" => false,
                "multiple" => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Submission::class,
            'required' => false,
            'attr' => array(
                'class' => 'row',
                'autocomplete' => 'off'
            )
        ]);
    }
}
