<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints as Assert;

class MediaEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', FileType::class, [
                'label' => 'Image',
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
                        ],
                        'mimeTypesMessage' => 'Merci de choisir uniquement des images du type gif, jpeg(jpg) ou png'
                    ])
                ]
            ])
            ->add('alt', TextType::class, [
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'placeholder' => 'Insérer un titre explicite (ex: irimi nage, Hervé en action, etc ...)'
                ],
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir un titre de photo'
                ]),
            ])
            ->add('caption', TextType::class, [
                'label' => 'Légende de l\'image',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => 'Légende non renseignée',
                'attr' => [
                    'placeholder' => 'Entrer une courte légende (stage club du --/--/--, galette de rois 2019, etc...)'
                ]
            ])
            ->add('takenAt', DateType::class, [
                'label' => 'Date de prise de vue',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => null,
                'invalid_message' => 'Veuillez saisir la date correspondant à la prise de la photo',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
