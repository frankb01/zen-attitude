<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TeacherEditMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grades', null, [
                'label' => 'Sélectionnez le grade actuel',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
            ->add('technics', null, [
                'label' => 'Sélectionnez la ou les techniques à travailler(maintenir ctrl pour multiple sélections)',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
            ])
            ->add('teacher_comment', null, [
                'label' => 'Laisser un commentaire à l\'élève',
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
