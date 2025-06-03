<?php

namespace App\Form;

use App\Entity\Examens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamensForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cout')
            ->add('dateexamen')
            ->add('preacquis')
            ->add('description')
            ->add('resultat')
            ->add('codeexamen')
            ->add('maladies')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Examens::class,
        ]);
    }
}
