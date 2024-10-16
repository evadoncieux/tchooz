<?php

namespace App\Form\ClothingItem;

use App\Entity\ClothingItem;
use App\Enum\ClothingCategory;
use App\Enum\ClothingColor;
use App\Enum\ClothingMaterial;
use App\Enum\ClothingStyle;
use App\Enum\ClothingWeather;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ClothingItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
            ])
            ->add('material', ChoiceType::class, [
                'choices' => $this->getSortedChoices(ClothingMaterial::cases()),
                'choice_label' => fn($choice) => $choice->value,
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('weather', ChoiceType::class, [
                'choices' => ClothingWeather::getSortOrder(),
                'choice_label' => fn($choice) => $choice->value,
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('colors', ChoiceType::class, [
                'choices' => $this->getSortedChoices(ClothingColor::cases()),
                'choice_label' => fn($choice) => $choice->value,
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('styles', ChoiceType::class, [
                'choices' => $this->getSortedChoices(ClothingStyle::cases()),
                'choice_label' => fn($choice) => $choice->value,
                'multiple' => true,
                'expanded' => false,
            ])->add('category', ChoiceType::class, [
                'choices' => $this->getSortedChoices(ClothingCategory::cases()),
                'choice_label' => fn($choice) => $choice->value,
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    private function getSortedChoices(array $choices): array
    {
        $sortedChoices = $choices;
        usort($sortedChoices, static fn($a, $b) => strcmp($a->value, $b->value));
        return $sortedChoices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClothingItem::class,
        ]);
    }
}
