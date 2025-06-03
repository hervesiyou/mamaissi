<?php

namespace App\Form;

use App\Entity\Dossiermedical;
use App\Entity\Patients;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossiermedicalForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datecreation')
            ->add('lieucreation')
            ->add('tuteur')
            ->add('photo')
            ->add('numerodossier')
            ->add('etatcivil')
            ->add('groupesanguin')
            ->add('rhesus')
            ->add('electrophorese')
            ->add('antecedentpersonnel')
            ->add('antecedentfamillial')
            ->add('allergies')
            ->add('facteurrisque')
            ->add('vaccindepistage')
            ->add('biographie')
            ->add('maladies')
            ->add('patient', EntityType::class, [
                'class' => Patients::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossiermedical::class,
        ]);
    }
}
