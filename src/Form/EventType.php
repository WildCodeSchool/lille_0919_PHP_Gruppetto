<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameEvent', TextType::class, [
                'label' => false,
                'required'=>true,
                'attr'=> [
                    'placeholder'=> "Nom de l'événement",
                    'class' => 'green-input'
                ]
            ])
            ->add('levelEvent', NumberType::class, [
                'label' => false,
                'required'=>false,
                'attr' => [
                    'placeholder' => "Niveau de difficulté",
                    'class' => 'green-input'
                ]
            ])
            ->add('dateEvent', DateType::class, [
                'label'=>false,
                'required' => true,
                'attr'=> [
                    'class' => ''
                ]
            ])
            ->add('timeEvent', DateType::class, [
                'label'=>false,
                'required' => true,
                'attr'=> [
                    'class' => ''
                    ]
                ])
            ->add('sport', EntityType::class, [
                "choice_label" => 'sportName',
                'label'=>true,
                'required' => true,
                'class' => Sport::class
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'required'=>false,
                'attr'=> [
                    'placeholder'=> "Description",
                    'class' => 'green-input'
                ]
            ])
            ->add('participantLimit', NumberType::class, [
                'label' => false,
                'required'=>true,
                'attr' => [
                    'placeholder' => "Limite de participants",
                    'class' => 'green-input'
                ]
            ])
            ->add('placeEvent', TextType::class, [
                'label' => false,
                'required'=>true,
                'attr'=> [
                    'placeholder'=> "Lieu",
                    'class' => 'green-input'
                ]
            ])
        ;
        $options = null;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
