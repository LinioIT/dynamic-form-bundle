<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TextAreaField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = 'textarea';
        $this->formlyFieldConfiguration['templateOptions']['type'] = 'textarea';

        return $this->formlyFieldConfiguration;
    }

}
