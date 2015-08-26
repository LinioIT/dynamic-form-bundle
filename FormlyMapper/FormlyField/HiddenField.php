<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class HiddenField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getFieldType()
    {
        return 'hidden';
    }
}
