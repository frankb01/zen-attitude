<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('oldPassword', PasswordType::class, [
            'label' => 'Mot de passe actuel',
            'label_attr' => [
                'class' => 'text-primary'
            ],
            'constraints' => 
                new UserPassword([
                    'message' => 'Veuillez renseigner votre mot de passe actuel'
                ]),
            'mapped' => false
        ])
        ->add('newPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'options' => [
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ],
            'constraints' => new NotBlank([
                'message' => 'Veuillez saisir votre nouveau mot de passe'
            ]),
            'invalid_message' => 'Les deux mots de passe doivent être identiques',
            'first_options'  => array('label' => 'Nouveau mot de passe'),
            'second_options' => array('label' => 'Répéter le mot de passe'),
            'mapped' => false
        ]);
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
