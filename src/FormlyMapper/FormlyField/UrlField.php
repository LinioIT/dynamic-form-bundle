<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class UrlField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    protected function getFieldType()
    {
        return 'url';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFieldTypeConfiguration(): void
    {
        if (isset($this->fieldConfiguration['validation'])) {
            $validation = $this->fieldConfiguration['validation'];

            if (isset($validation[\Symfony\Component\Validator\Constraints\Url::class])) {
                $constraint = $validation[\Symfony\Component\Validator\Constraints\Url::class];
                $this->formlyFieldConfiguration['validation']['messages']['url'] = $constraint['message'] ?? '';
            }
        }
    }
}
