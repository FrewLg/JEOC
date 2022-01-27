<?php

namespace App\Form;

use App\Entity\PublishedSubmissionAttachment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublishedSubmissionAttachmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attachment_file')
            ->add('description')
            ->add('uploaded_at')
            ->add('is_approved')
            ->add('dataset_label')
            ->add('sample_size')
            ->add('location')
            ->add('codebook')
            ->add('study_region')
            ->add('attachment_type')
            ->add('data_source')
            ->add('published_submission')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublishedSubmissionAttachment::class,
        ]);
    }
}
