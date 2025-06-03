<?php

namespace App\Form;

use App\Entity\Patients;
use App\Entity\Personnels;
use App\Entity\Rendezvous;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezvousForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour')
            ->add('mois')
            ->add('annee')
            ->add('etat')
            ->add('but')
            ->add('datecreation')
            ->add('date')
            ->add('heurevalide')
            ->add('heure')
            ->add('quartier')
            ->add('region')
            ->add('ville')
            ->add('prix')
            ->add('specialite')
            ->add('coderdv')
            ->add('modevisio')
            ->add('codepatient')
            ->add('titreconf')
            ->add('dateconf')
            ->add('idconf')
            ->add('cssclass')
            ->add('etatpaiement')
            ->add('datepaiement')
            ->add('code')
            ->add('patient', EntityType::class, [
                'class' => Patients::class,
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
            'data_class' => Rendezvous::class,
        ]);
    }
}
