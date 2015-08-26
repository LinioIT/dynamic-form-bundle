<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class PasswordField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'password';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        // TODO: Implement generateSpecificConfiguration() method.
    }
}
