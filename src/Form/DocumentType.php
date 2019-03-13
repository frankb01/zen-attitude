<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du document',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'placeholder' => 'Ex: Fiche d\'inscription 2019'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez Donner un titre explicite'
                    ]),
                ]
            ])
            ->add('path', FileType::class, [
                'label' => 'Document',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'placeholder' => 'Télécharger un document'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une image à poster'
                    ]),
                    new Assert\File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci de choisir uniquement des fichiers du type PDF, jpeg(jpg)'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
