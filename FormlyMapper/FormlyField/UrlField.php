<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class UrlField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getFieldType()
    {
        return 'url';
    }
}
