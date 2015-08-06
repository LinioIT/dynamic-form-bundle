<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class FileField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = 'file';
        $this->formlyFieldConfiguration['templateOptions']['type'] = 'file';

        return $this->formlyFieldConfiguration;
    }

}
