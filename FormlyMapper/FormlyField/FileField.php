<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class FileField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = $this->getTemplateFieldType();
    }
}
