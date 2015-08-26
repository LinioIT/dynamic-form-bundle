<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TextareaField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        $this->formlyFieldConfiguration['type'] = $this->getTemplateFieldType();
    }
}
