<?php

namespace App\Form;

use App\Entity\StageApi;
use App\Entity\Carsharing;
use Doctrine\ORM\EntityRepository;
use App\Repository\StageApiRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type as Type;

class CarsharingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stage_api', EntityType::class, [
                'class' => StageApi::class,
                'label' => 'Stage',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
            ->add('seat_number', Type\IntegerType::class, [
                'label' => 'Nombre de place',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'min' => 1
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Vous devez spécifier un nombre de place'
                    ]),
                    new Range([
                        'min' => 1,
                        'minMessage' => 'Vous devez proposer au minimum 1 place'
                    ])
                ]
            ])
            ->add('appointment_at', Type\TimeType::class, [
                'label' => 'Heure de rendez-vous',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'widget' => 'single_text',
                'empty_data' => 'un string',
                'attr' => ['class' => 'timepicker'],
                'constraints' => [
                    new Assert\Time(),
                ]
            ])
            ->add('appointment_to', Type\TextType::class, [
                'label' => 'Lieu de rendez-vous',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Vous devez spécifier un lieu de rendez-vous'
                    ]),
                    new Assert\Length([
                        'minMessage' => 'Le lieu de rendez-vous est trop court, {{ limit }} caractère minimunm',
                        'min' => 5
                    ])
                ]
            ])
            ->add('comment', Type\TextareaType::class,[
                'label' => 'Ajouter un commentaire (facultatif)',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => ['rows' => '2'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Carsharing::class,
        ]);
    }
}
