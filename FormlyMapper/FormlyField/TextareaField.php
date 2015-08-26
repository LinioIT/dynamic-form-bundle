<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TextareaField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getFieldType()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function buildFieldTypeConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = $this->getFieldType();
    }
}
