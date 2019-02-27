<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'action' => '/connexion',
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
