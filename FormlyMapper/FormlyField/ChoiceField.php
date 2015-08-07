<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class ChoiceField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $type = 'select';
        if (isset($this->fieldConfiguration['options']['expanded']) && $this->fieldConfiguration['options']['expanded'] === true) {
            $type = 'radio';

            if (isset($this->fieldConfiguration['options']['multiple']) && $this->fieldConfiguration['options']['multiple'] === true) {
                $type = 'checkbox';
            }
        }

        $typeOptions = $type;

        if (!isset($this->fieldConfiguration['options']['expanded']) || $this->fieldConfiguration['options']['expanded'] === false) {
            if (isset($this->fieldConfiguration['options']['multiple']) && $this->fieldConfiguration['options']['multiple'] === true) {
                $typeOptions = 'multiple';
            }
        }

        $this->formlyFieldConfiguration['type'] = $type;
        $this->formlyFieldConfiguration['templateOptions']['type'] = $typeOptions;

        if (isset($this->fieldConfiguration['options']['options'])) {
            $choices = $this->fieldConfiguration['options']['options'];

            $this->formlyFieldConfiguration['templateOptions']['options'] = $choices;
        }

        return $this->formlyFieldConfiguration;
    }

}
