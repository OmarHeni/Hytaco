<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;

class AddUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class
            )
            ->add('confirmPassword', PasswordType::class
            )
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'Client' => 'ROLE_CLIENT',
                    'Fournisseur' => 'ROLE_FOUR',
                    'Admin' => 'ROLE_ADMIN',
                ],
            ])
            ->add('Adresse')
            ->add('prenom')
            ->add('nom')
            ->add('imageFile',FileType::class,[
                'required'=>false
            ])
            ->add('Telephone')
            ->add('captcha', RecaptchaType::class, [
                // You can use RecaptchaSubmitType
                // "groups" option is not mandatory
                'constraints' => new Recaptcha2([]),

            ])
            ->add('Submit',SubmitType::class);
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
