<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TimeField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'time';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        // TODO: Implement generateSpecificConfiguration() method.
    }
}
