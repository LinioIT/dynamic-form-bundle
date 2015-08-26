<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class TextField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        // TODO: Implement generateSpecificConfiguration() method.
    }
}
