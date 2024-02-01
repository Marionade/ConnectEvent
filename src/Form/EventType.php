<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
            ])
            ->add('title')
            ->add('duration')
            ->add('start_date')
            ->add('end_date')
            ->add('location')
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'class' => 'form-bloc',
                ],
            ])
            ->add('Logistic', TextareaType::class, [
                'label' => 'Logistique',
                'required' => false,
                'attr' => [
                    'class' => 'form-bloc',
                ],
            ])
            ->add('activities', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'type',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
