<?php

namespace App\Form;

use App\Entity\Usine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('public')
            ->add('member', null, ['disabled' => true])
            ->add('tanks', null,
            ['by_reference' => false,
            'multiple' => true, 
            'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usine::class,
        ]);
    }
}
