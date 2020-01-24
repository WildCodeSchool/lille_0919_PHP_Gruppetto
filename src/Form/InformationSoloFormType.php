<?php

namespace App\Form;

use App\Entity\ProfilSolo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationSoloFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                "label" => false,
                "required" => true,
                "attr" => [
                    "placeholder" => "Nom ",
                    "class" => "green-input"
                ]
            ])

            ->add('firstname', TextType::class, [
                "label" => false,
                "required" => true,
                "attr" => [
                    "placeholder" => "Prenom ",
                    "class" => "green-input"
                ]
            ])
            ->add('birthdate', BirthdayType::class, [
                "label" => false,
                "required" => true,
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Femme' => true,
                    'Homme' => false,
                ]
            ])
            ->add('phone', TelType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Numero de telephone ",
                    "class" => "green-input"
                ]
            ])
            ->add('avatar', FileType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    'placeholder'=>"avatar"],
            ])
            ->add('description', TextareaType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Description ",
                    "class" => "green-input"
                ]
            ])
            ->add('emergencyContactName', TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "contact d'urgence ",
                    "class" => "green-input"
                ]
            ])
            ->add('emergencyPhone', TelType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Numero d'urgence ",
                    "class" => "green-input"
                ]
            ]);
        $options = null;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfilSolo::class
        ]);
    }
}
