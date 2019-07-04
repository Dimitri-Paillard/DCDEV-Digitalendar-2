<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Event;
use App\Entity\Language;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["label" => "Titre"])
            ->add('pictureFile', FileType::class, [
                "label" => " Image",
                'mapped'=> false,
                'required'=> false
            ])
            ->add('description',TextareaType::class )
            ->add('city', EntityType::class, ["class" => City::class, "label" => "Ville"])
            ->add('language', EntityType::class, ["class" => Language::class, "label" => "Langue", "multiple" => true])
            ->add('dateStart', DateType::class, ["label" => "Date de début"])
            ->add('dateEnd', DateType::class, ["label" => "Date de fin"])
            ->add('url', UrlType::class, ["label" => "Url"])
            ->add('price', NumberType::class, ["label" => "Prix"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
