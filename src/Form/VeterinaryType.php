<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Veterinary;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VeterinaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('postalCode', TextType::class, ['label' => 'Code postal'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('phonep', TextType::class, ['label' => 'Téléphone'])
            ->add('imageFileName', TextType::class, [
                'label' => 'Image',
                'required' => false,
                'empty_data' => 'default.jpg',
            ])
            ->add('activities', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'description',
                'multiple' => true,
                'label' => 'Activités'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class, 
                'choice_label' => 'name',  
                'label' => 'Catégorie',   
                'placeholder' => 'Sélectionnez une catégorie',
            ])
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Veterinary::class,
        ]);
    }
}
