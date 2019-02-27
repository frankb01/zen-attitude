<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => '',
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisi votre prénom'
                ])
                

            ])
            ->add('firstname', TextType::class, [
                'label' => 'Nom de famille',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => '',
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir votre nom de famille'
                ])

            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'widget' => 'single_text',
                'empty_data' => null,
                'invalid_message' => 'Veuillez saisir votre date de naissance',
                'constraints' => [
                    new Range([
                        'max' => 'now',
                        'maxMessage' => 'Votre date de naissance doit être inférieure à la date d\'aujourd\'hui'
                    ])
                ]

            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => '',
                'constraints' => [ 
                    new NotBlank([
                        'message' => 'Veuillez saisir le numéro de téléphone de l\'utilisateur'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 18
                    ]),
                    new Regex([
                        'pattern' => "/^[^a-zA-Z][0-9 . ]+/"
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => '',
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir votre adresse email'
                ])
            ])
            ->add('license', TextType::class, [
                'label' => 'Numéro de licence',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
