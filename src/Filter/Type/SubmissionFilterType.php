<?php


namespace App\Filter\Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class SubmissionFilterType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options) {
	$builder->add('sub_title', Filters\TextFilterType::class); 
        $builder->add('title', Filters\TextFilterType::class);  
    
    }

    public function getBlockPrefix() {
        return 'submission_filter';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }

}
