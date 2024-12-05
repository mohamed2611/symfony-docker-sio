<?php

namespace App\Form;

use App\Entity\FollowUp;
use App\Entity\Veterinary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class FollowUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contactName', TextType::class, ['label' => 'Contact'])
            ->add('comment', TextType::class, ['label' => 'Commentaire'])
            ->add('callDate', null, ['label' => 'Date Appel'], [
                'widget' => 'single_text'],)
            
                ->add('veterinary', EntityType::class, [
                'class' => Veterinary::class,
                'choice_label' => 'id',
                'label' => 'Vétérinaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FollowUp::class,
        ]);
    }

    
}
