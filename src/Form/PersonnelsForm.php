<?php

namespace App\Form;

use App\Entity\Personnels;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnelsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image')
            ->add('cv')
            ->add('diplome')
            ->add('specialite')
            ->add('valide')
            ->add('diplomevalide')
            ->add('prixconsultation')
            ->add('nbvisite')
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
            ->add('date_validation')
            ->add('date_inscription')
            ->add('datereinitialisation')
            ->add('dateLastconnection')
            ->add('shortcode')
            ->add('oldpwdlist')
            ->add('token')
            ->add('mobiletelephone')
            ->add('imc')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnels::class,
        ]);
    }
}
