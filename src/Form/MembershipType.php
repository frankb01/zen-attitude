<?php

namespace App\Form;

use App\Entity\Membership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MembershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('age', ChoiceType::class, [
                'label' => 'Limite d\'âge',
                'choices' => [
                    'Moins de 18 ans' => 'Moins de 18 ans',
                    'A partir de 18 ans' => 'A partir de 18 ans',
                ],
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'class' => 'dropdown'
                ],
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Tarif',
                'label_attr' => [
                    'class' => 'text-primary'
                ],
                'attr' => [
                    'placeholder' => 'Entrer le montant de la cotisation'
                 ],
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membership::class,
        ]);
    }
}
