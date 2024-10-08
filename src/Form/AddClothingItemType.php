<?php

namespace App\Form;

use App\Entity\ClothingItem;
use App\Enum\ClothingCategory;
use App\Enum\ClothingColor;
use App\Enum\ClothingMaterial;
use App\Enum\ClothingStyle;
use App\Enum\ClothingWeather;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddClothingItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,

            ])
            ->add('material', EnumType::class, [
                'class' => ClothingMaterial::class,
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('weatherTypes', ChoiceType::class, [
                'choices' => ClothingWeather::cases(),
                'choice_label' => fn($choice) => $choice->value,
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('colors', ChoiceType::class, [
                'choices' => ClothingColor::cases(),
                'choice_label' => fn($choice) => $choice->value,
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('styles', ChoiceType::class, [
                'choices' => ClothingStyle::cases(),
                'choice_label' => fn($choice) => $choice->value,
                'multiple' => true,
                'expanded' => false,
            ])->add('categories', ChoiceType::class, [
                'choices' => ClothingCategory::cases(),
                'choice_label' => fn($choice) => $choice->value,
                'multiple' => true,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClothingItem::class,
        ]);
    }
}
