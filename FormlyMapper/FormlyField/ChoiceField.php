<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class ChoiceField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = 'checkbox';
        $this->formlyFieldConfiguration['templateOptions']['type'] = 'checkbox';
        if (isset($this->fieldConfiguration['options']['options'])) {
            $choices = $this->fieldConfiguration['options']['options'];
            $this->formlyFieldConfiguration['templateOptions']['options'] = $choices;
        }

        return $this->formlyFieldConfiguration;
    }

}
