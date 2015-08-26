<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class HiddenField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        // TODO: Implement generateSpecificConfiguration() method.
    }
}
