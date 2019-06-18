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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class AdminNewMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir le prénom de l\'utilisateur'
                ]),
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Nom de famille',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir le nom de famille de l\'utilisateur'
                ]),
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'widget' => 'single_text',
                'empty_data' => null,
                'invalid_message' => 'Veuillez saisir la date de naissance de l\'utilisateur',
                'constraints' => [
                    new Range([
                        'max' => 'now',
                        'maxMessage' => 'Vous ne pouvez pas inscrire quelqu\'un qui n\'est pas encore né'
                    ])
                ]
            ])
            ->add('address', TextareaType::class, [
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
                        'pattern' => "/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/", //regex pour sécuriser le numéro de téléphone,prenant en compte l'indicatif pays (+33) et la saisie avec ou sans espaces ou tirets
                        'message' => 'Veuillez entrer un numéro de téléphone valide'
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir l\'adresse email de l\'utilisateur'
                ])
            ])
            ->add('password', RepeatedType::class, [
                'empty_data' => '',
                'required' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'first_options'  => [
                    'label' => 'Mot de passe ( doit contenir 8 caractères minimum)',
                    'label_attr' => [
                        'class' => 'text-primary'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir le mot de passe de l\'utilisateur',
                        ]),
                        new Length([
                            'min' => 8, // TODO : Penser à modifier la limite à 8
                            'minMessage' => 'Le mot de passe doit contenir {{ limit }} caractères minimum',
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe',
                    'label_attr' => [
                        'class' => 'text-primary'
                    ],
                    'constraints' => new NotBlank([
                        'message' => 'Veuillez resaisir le mot de passe de l\'utilisateur',
                    ]),
                ],
            ])
            ->add('license', TextType::class, [
                'label' => 'Numéro de licence',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
            ->add('responsability', ChoiceType::class, [
                'label' => 'Responsabilité club',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'choices' => [
                    'membre' => 'membre',
                    'secrétaire' => 'secrétaire',
                    'trésorier' => 'trésorier',
                    'président' => 'président',
                ],
                'attr' => [
                    'class' => 'dropdown'
                ],
            ])
            ->add('role', null, [
                'label' => 'Rôle sur le site',
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
