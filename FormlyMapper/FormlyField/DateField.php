<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class DateField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $this->formlyFieldConfiguration['templateOptions']['type'] = 'date';

        return $this->formlyFieldConfiguration;
    }

}
