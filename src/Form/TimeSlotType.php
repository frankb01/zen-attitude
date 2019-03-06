<?php

namespace App\Form;

use App\Entity\TimeSlot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TimeSlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', TextType::class, [
                'label' => 'Jour',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le jour du cours'
                    ])
                ]
            ])
            ->add('level', TextType::class, [
                'label' => 'Pour qui ?',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'placeholder' => 'Ex:Débutan(e)s/Gradé(e)s'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir qui peut assister à ce cours (gradés ou débutants)'
                    ])
                ]
            ])
            ->add('schedule', TextType::class, [
                'label' => 'horaires',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'placeholder' => 'Ex: 8h45 à 20h30',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir les horaires du cours'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TimeSlot::class,
        ]);
    }
}
