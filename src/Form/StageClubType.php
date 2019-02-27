<?php

namespace App\Form;

use App\Entity\StageClub;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class StageClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du stage',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un nom pour le stage'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le nom du stage doit contenir {{ limit }} caractères minimum',
                    ])
                ]
            ])
            ->add('place', null, [
                'label' => 'Lieu où le stage va se dérouler',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner l\'adresse où va se dérouler le stage'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le lieu du stage doit contenir {{ limit }} caractères minimum',
                    ])
                ]
            ])
            ->add('date', DateType::class, [
                'label' => 'Date du stage',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => null,
                'invalid_message' => 'Veuillez saisir une date de stage',
                'widget' => 'single_text',
                'constraints' => [
                    new Range([
                        'min' => 'now',
                        'minMessage' => 'la date ne peut pas être une date passée et ne peut être égale la date du jour'
                    ])
                ]
            ])
            ->add('poster', FileType::class,[
                'label' => 'Affiche (jpg,png,gif)',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'placeholder' => 'Télécharger une image'
                ],
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/pdf',
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => 'Merci de choisir uniquement des images du type gif, jpeg(jpg), png ou pdf'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StageClub::class,
        ]);
    }
}
