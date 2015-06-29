<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyFields;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class NumberField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $this->formlyFieldConfiguration['templateOptions']['type'] = 'number';

        if (isset($this->fieldConfiguration['validation'])) {
            $validation = $this->fieldConfiguration['validation'];

            if (isset($validation['Symfony\Component\Validator\Constraints\Range'])) {
                $rangeValidator = $validation['Symfony\Component\Validator\Constraints\Range'];
                $this->formlyFieldConfiguration['templateOptions']['min'] = $rangeValidator['min'];
                $this->formlyFieldConfiguration['templateOptions']['max'] = $rangeValidator['max'];
            }
        }

        return $this->formlyFieldConfiguration;
    }
}
