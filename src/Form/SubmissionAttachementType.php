<?php

namespace App\Form;

use App\Entity\SubmissionAttachement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class SubmissionAttachementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile',VichFileType::class,[
                'allow_delete' => false,
                // 'delete_label' => 'Remove file',
           //     'download_uri' => '...',
               'download_label' => 'Download file',
            ])
            ->add('name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubmissionAttachement::class,
        ]);
    }
}
