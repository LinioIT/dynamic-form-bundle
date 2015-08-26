<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class DateField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'date';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        // TODO: Implement generateSpecificConfiguration() method.
    }
}
