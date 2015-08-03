<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyFields;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class CheckboxField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = 'checkbox';
        $this->formlyFieldConfiguration['templateOptions']['type'] = 'checkbox';
        $this->formlyFieldConfiguration['templateOptions']['options'] = [];

        return $this->formlyFieldConfiguration;
    }

}
