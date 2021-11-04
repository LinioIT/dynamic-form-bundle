<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirthdayTypeExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined(['order', 'minAgeAllowed', 'maxAgeAllowed']);
    }

    public static function getExtendedTypes(): iterable
    {
        return [BirthdayType::class];
    }
}
