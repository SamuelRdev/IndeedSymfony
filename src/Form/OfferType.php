<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\ContractType;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('address')
            ->add('postal_code')
            ->add('city')
            ->add('contract', EntityType::class, [
                "class" => Contract::class,
                "label" => 'Contract',
                "choice_label" => 'name',
                'multiple' => false,
                'expanded' => true,
            ])

            ->add('contract_type', EntityType::class, [
                "class" => ContractType::class,
                "label" => 'Contract',
                "choice_label" => 'name',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('ended_at');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
