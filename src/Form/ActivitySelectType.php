<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Activity;
use App\Entity\Veterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ActivitySelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
        $builder
        ->add('activity', EntityType::class, [
        'class' => Activity::class,
        'choice_label' => 'description',
        'multiple' => false,
        'label' => 'Activité',
        'placeholder' => 'Choisissez une Activité',
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
