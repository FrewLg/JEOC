<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Utils\Constants;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = [
            "System Admin" => Constants::ROLE_ADMIN,
            "President" => Constants::PRESIDENT,
             "Vice President" => Constants::VICE_PRESIDENT,
              "Directorate" => Constants::ROLE_DIRECTORATE,
               "College Coordinator" => Constants::ROLE_COLLEGECOORDINATOR,
                "Work Unit" => Constants::ROLE_WORK_UNIT,
                "Reviewer" => Constants::ROLE_REVIEWER,
        ];

        $builder

            ->add('roles', ChoiceType::class, [
                "choices" => $roles,
             'mapped' => false, "multiple" => true,
              "placeholder" => "Select Role"])


            ->add('midle_name')
            ->add('last_name')
            ->add('first_name')
            ->add('gender', ChoiceType::class, ["choices" => ["Male"=>"Male","Female"=>"Female"]
            ,  "placeholder" => "Select Gender"])
            
            ->add('affiliation')
            ->add('suffix')
            ->add('phoneNumber')
            ->add('bio',TextareaType::class,
            [
'attr'=>[
                    'class' => 'form-control col col-md-3',
                    'required'=>false,
]
            ])
            ->add('birth_date')
            // ->add('address')
            // ->add('college')

           
            // ->add('department')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,         
        ]);
    }
}
