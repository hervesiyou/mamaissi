<?php

namespace App\Form;

use App\Entity\Dossiermedical;
use App\Entity\Patients;
use App\Entity\Programmes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('age')
            ->add('image')
            ->add('profession')
            ->add('statutmatrimonial')
            ->add('valide')
            ->add('nomComplet')
            ->add('sexe')
            ->add('nom')
            ->add('prenom')
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('adresse')
            ->add('zipCode')
            ->add('ville')
            ->add('pays')
            ->add('type')
            ->add('telephone')
            ->add('date_naiss')
            ->add('dateLastconnection')
            ->add('date_validation')
            ->add('date_inscription')
            ->add('datereinitialisation')
            ->add('shortcode')
            ->add('token')
            ->add('oldpwdlist')
            ->add('nombreenfant')
            ->add('mobiletelephone')
            ->add('nbvisite')
            ->add('dossiermedical', EntityType::class, [
                'class' => Dossiermedical::class,
                'choice_label' => 'id',
            ])
            ->add('programmes', EntityType::class, [
                'class' => Programmes::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patients::class,
        ]);
    }
}
