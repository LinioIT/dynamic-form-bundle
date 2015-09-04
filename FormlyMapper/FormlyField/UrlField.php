<?php

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
    protected function buildFieldTypeConfiguration()
    {
        if (isset($this->fieldConfiguration['validation'])) {
            $validation = $this->fieldConfiguration['validation'];

            if (isset($validation['Symfony\Component\Validator\Constraints\Url'])) {
                $constraint = $validation['Symfony\Component\Validator\Constraints\Url'];
                $this->formlyFieldConfiguration['validation']['messages']['url'] =  isset($constraint['message']) ? $constraint['message'] : '';
            }
        }
    }
}
