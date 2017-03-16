<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class FileField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    protected function getFieldType()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFieldTypeConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = $this->getFieldType();
    }
}
