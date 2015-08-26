<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TextareaField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    protected function getFieldType()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFieldTypeConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = $this->getFieldType();
    }
}
