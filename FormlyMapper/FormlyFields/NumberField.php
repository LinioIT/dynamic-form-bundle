<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyFields;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class NumberField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $fieldConfiguration = [];

        $fieldConfiguration['key'] = $this->fieldConfiguration['name'];
        $fieldConfiguration['type'] = 'input';

        $templateOptions = [];

        $templateOptions['type'] = 'number';

        if (isset($this->fieldConfiguration['options'])) {
            if (isset($this->fieldConfiguration['options']['label'])) {
                $templateOptions['label'] = ucfirst($this->fieldConfiguration['options']['label']);
                $templateOptions['placeholder'] = ucfirst($this->fieldConfiguration['options']['label']);
            } else {
                $templateOptions['label'] = ucfirst($this->fieldConfiguration['name']);
                $templateOptions['placeholder'] = ucfirst($this->fieldConfiguration['name']);
            }

            foreach ($this->fieldConfiguration['options'] as $option => $value) {
                $templateOptions[$option] = $value;
            }

            $fieldConfiguration['templateOptions'] = ($templateOptions);
        }

        return $fieldConfiguration;
    }
}
