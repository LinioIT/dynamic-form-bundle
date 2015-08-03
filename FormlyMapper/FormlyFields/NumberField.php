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
                $constraint = $validation['Symfony\Component\Validator\Constraints\Range'];

                $this->formlyFieldConfiguration['templateOptions']['min'] = $constraint['min'];

                if (isset ($constraint['minMessage'])) {
                    $this->formlyFieldConfiguration['validation']['messages']['min'] = $constraint['minMessage'];
                }

                $this->formlyFieldConfiguration['templateOptions']['max'] = $constraint['max'];

                if (isset ($constraint['maxMessage'])) {
                    $this->formlyFieldConfiguration['validation']['messages']['max'] =  $constraint['maxMessage'];
                }
            }
        }

        return $this->formlyFieldConfiguration;
    }
}
