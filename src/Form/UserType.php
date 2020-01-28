<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class UserType extends AbstractType
{
    // form for password//

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                    'mapped'=>false
            ))
            ->add('password', RepeatedType::class, [
                'constraints' => [new Length(['min' => 6]), new NotBlank(), new Regex([
                //at least one uppercase letter, one lowercase letter, one number and one special character
                'pattern' => '#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]#',
                'message' => "Votre mot de passe doit contenir au moins 6 charactères dont au moins une majuscule,
                     une minuscule, un chiffre et un charactère spécial"
                ])],
                'type'=> PasswordType::class,
                'invalid_message' => 'Les mots de passent doivent correspondre',
                'options'=> ['attr' => ['class'=>'password-field']],
                'required'=> true,
                'first_options'=> ['label'=>'Password'],
                'second_options'=> ['label'=> 'Repeat Password'],
            ])
        ->add('save', SubmitType::class, [
            'attr'=>['class'=>'save']]);
        $options= null;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
