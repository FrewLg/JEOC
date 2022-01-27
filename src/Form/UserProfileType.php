<?php

namespace App\Form;

use App\Entity\AcademicRank;
use App\Entity\College;
use App\Entity\Department;
use App\Entity\EducationalLevel;
use App\Entity\UserInfo;
// use App\Entity\Suffixe;
use App\Entity\Suffixe;

use Attribute;

use Doctrine\Common\Annotations\Annotation\Required;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
 use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType; 
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;




class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
       

            $builder
            ->add('first_name' ,TextType::class,[
                'required' => true,

                'label'                 =>'Given name',
                                'attr'=>[]
                                ]
                            )
            ->add('midle_name' ,TextType::class,[
'label'                 =>'Middle name',
'required' => true,

                'attr'=>[]
                ]
            )
            
            ->add('last_name' ,TextType::class,[
                'label'                 =>'Sur name',
                'required' => true,

                                'attr'=>[]
                                ]
                            )
            
            ->add('birth_date' 
            , DateType::class, array(
                            'placeholder' => [
                  'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                          'widget' => 'single_text',
                          'format' => 'yyyy-MM-dd',
                             'attr' => array(
                
                       'required' => true,
                'class'=>'form-group col-md-4',
                   )
                      ))
//             ->add('bio' ,TextareaType::class,
//             [
//                 'required'=>false,

// 'attr'=>[
//                     'class' => 'form-control col col-md-3',
//                     'required'=>false,
// ]
//             ])
            // ->add('affiliation')
            ->add('phone_number') 
            ->add('alternative_email')
                   ->add('gender',  ChoiceType::class, [
            'choices' => [
               'Male' => 'Male',
             'Female' => 'Female',
             ],
            'expanded'=>true,
            'attr' => [
                    'class' => 'form-horizontal  col-md-3',
                  'required' => true,
                'multiple'=>false,
                   ] ,            
            	]) 
            ##########################
            ->add('researches', CollectionType::class, [
                'entry_type' => PublishedResearchType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                // 'data_class'=>false,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            
            ->add('suffix' ,EntityType::class,[
                'placeholder' => '--- Select Suffix ---',
                "class"=>Suffixe::class,
                "attr"=>[
                    "class"=>"select2 ",
                ]
            ])
            ->add('education_level',EntityType::class,[
                'placeholder' => '---Select Education level ---',
                "class"=>EducationalLevel::class,
                "attr"=>[
                    "class"=>"select2 ",
                ]
            ])
            
            ->add('academic_rank',EntityType::class,[
                'placeholder' => '---Select Academic rank---',
               
                "class"=>AcademicRank::class,
                "attr"=>[
                    "class"=>"select2 ",
                ]
            ])
            ->add('college',EntityType::class,[
                'placeholder' => '---Select College---',
                "class"=>College::class,
                "attr"=>[
                    "class"=>"select2 college",
                ]
            ])
            
        
           ;
        }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}

class UserProfilePictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
       

            $builder
         
            ->add('image', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                "attr"=>[
                    "accept"=>"image/*",
                    "class"=>"form-control",

                ]
            ]);
        }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}