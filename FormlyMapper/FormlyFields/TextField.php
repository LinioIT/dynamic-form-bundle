<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyFields;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TextField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        return $this->configuration;
    }
}
