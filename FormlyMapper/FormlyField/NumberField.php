<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class NumberField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    protected function getFieldType()
    {
        return 'number';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFieldTypeConfiguration()
    {
        if (isset($this->fieldConfiguration['validation'])) {
            $validation = $this->fieldConfiguration['validation'];

            if (isset($validation['Symfony\Component\Validator\Constraints\Range'])) {
                $constraint = $validation['Symfony\Component\Validator\Constraints\Range'];
                $this->formlyFieldConfiguration['templateOptions']['min'] = isset($constraint['min']) ? $constraint['min'] : '';

                if (isset($constraint['minMessage'])) {
                    $this->formlyFieldConfiguration['validation']['messages']['min'] = $constraint['minMessage'];
                }

                $this->formlyFieldConfiguration['templateOptions']['max'] = isset($constraint['max']) ? $constraint['max'] : '';

                if (isset($constraint['maxMessage'])) {
                    $this->formlyFieldConfiguration['validation']['messages']['max'] =  $constraint['maxMessage'];
                }
            }
        }
    }
}
