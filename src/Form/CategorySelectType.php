<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Veterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategorySelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
        $builder
        ->add('category', EntityType::class, [
        'class' => Category::class,
        'choice_label' => 'Name',
        'multiple' => false,
        'label' => 'Catégorie',
        'placeholder' => 'Choisissez une catégorie',
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
