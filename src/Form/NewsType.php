<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le titre de l\'actualité'
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le titre doit contenir {{ limit }} caractères minimum',
                    ])
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir un contenu pour l\'actualité'
                ])
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de l\'évènement',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'empty_data' => null,
                'invalid_message' => 'Veuillez saisir la date de l\'évènement à afficher',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
