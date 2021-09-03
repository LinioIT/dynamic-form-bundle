<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirthdayTypeExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined(['order', 'minYear', 'maxYear']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['order'] = $options['order'] ?? '';
        $view->vars['minYear'] = $options['minYear'] ?? '';
        $view->vars['maxYear'] = $options['maxYear'] ?? '';
    }

    public static function getExtendedTypes(): iterable
    {
        return [BirthdayType::class];
    }
}
