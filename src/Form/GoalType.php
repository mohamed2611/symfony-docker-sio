<?php

namespace App\Form;

use App\Entity\Goal;
use App\Entity\Product;
use App\Entity\Veterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class GoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('veterinary', EntityType::class, [
            'class' => Veterinary::class,
            'choice_label' => 'id',
            'label' => 'Vétérinaire', 
        ])
        ->add('product', EntityType::class, [
            'class' => Product::class,
            'choice_label' => 'id',
            'label' => 'Produit', 
        ])
        ->add('amount', TextType::class, [
            'label' => 'Montant'])
        
            ->add('year', IntegerType::class, [
                'label' => 'Année'
            ]);
    
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Goal::class,
        ]);
    }
}
