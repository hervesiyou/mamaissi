<?php

namespace App\Form;

use App\Entity\Consultations;
use App\Entity\Dossiermedical;
use App\Entity\Personnels;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateconsultation')
            ->add('medecin')
            ->add('donnees')
            ->add('synthese')
            ->add('decision')
            ->add('maladies')
            ->add('type')
            ->add('lieu')
            ->add('ilc')
            ->add('imc')
            ->add('dossiermedical', EntityType::class, [
                'class' => Dossiermedical::class,
                'choice_label' => 'id',
            ])
            ->add('personnel', EntityType::class, [
                'class' => Personnels::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultations::class,
        ]);
    }
}
