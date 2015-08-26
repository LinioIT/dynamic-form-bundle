<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TextField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getFieldType()
    {
        return 'text';
    }
}
