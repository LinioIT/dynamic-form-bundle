<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class FileField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getFieldType()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function buildFieldTypeConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = $this->getFieldType();
    }
}
