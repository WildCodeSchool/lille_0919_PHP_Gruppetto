<?php

namespace App\Form;

use App\Entity\ProfilClub;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProfilClubType extends AbstractType
{
    /**
     * Suppress all rules containing "unused" in this
     * class
     * @SuppressWarnings("unused")
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameClub', TextType::class, ['label'=>null])
            ->add('cityClub', TextType::class, ['label'=>null])
            ->add('logoClub', FileType::class, ['label'=>null,
                // unmapped because the field is not associate to any entity//
                'mapped'=> false,
                // require is false, don't have to re-upload if the user edit is profil//
                'required'=> false,
                // security applications, max size, documents type//
                 'constraints'=> [
                     new File([
                         'maxSize'=> '500K',
                         'maxSizeMessage'=> 'The file is too large',
                         'mimeTypes' =>[
                             'image/jpeg',
                             'image/png',
                         ],
                         'mimeTypesMessage'=>'Merci de sélectionner un fichier png ou jpg.'
                     ])
                 ]
            ])

            ->add('descriptionClub', TextareaType::class, ['label'=>null]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfilClub::class,
        ]);
    }
}
