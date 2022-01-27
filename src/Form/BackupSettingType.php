<?php

namespace App\Form;

use App\Entity\BackupSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BackupSettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emailto')

            ->add('site')

            ->add('emailfrom')
            ->add('email_subject')
            ->add('db_user')
            ->add('db_password')
            ->add('destination_dir')
            ->add('logfile_name')
            ->add('mysql_host')
            ->add('source_dir')
            ->add('remote_machine_ip')
            ->add('emailto_cc')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BackupSetting::class,
        ]);
    }
}
