<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HelpMessageTypeExtension extends AbstractTypeExtension
{
    /**
     * @return string
     */
    public function getExtendedType()
    {
        return FormType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined(['help']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['help'] = $options['help'] ?? '';
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
