<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\EventSearch;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', EntityType::class, [
                'class' => City::class,
                'label' => 'Ville :',
                'choice_label' => 'name',
                'placeholder' => 'Selectionner un ville',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
            ->add('artist', SearchType::class, [
                'label' => 'Artiste :',
                'attr' => [
                    'placeholder' => 'Nom de l"artiste',
                ],
                'required' => false,
            ])
            ->add('dateStart', DateType::class, [
                'label' => 'Entre le :',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Et le :',
                'widget' => 'single_text',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventSearch::class,
        ]);
    }
}
