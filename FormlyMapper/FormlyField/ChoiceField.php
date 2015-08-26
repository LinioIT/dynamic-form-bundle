<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class ChoiceField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    public function getTemplateFieldType()
    {
        return 'select';
    }

    /**
     * {@inheritdoc}
     */
    public function generateSpecificConfiguration()
    {
        $type = $this->getTemplateFieldType();

        $typeOptions = $type;
        $expanded = false;
        $multiple = false;

        if (isset($this->fieldConfiguration['options']['expanded'])) {
            $expanded = $this->fieldConfiguration['options']['expanded'];
        }

        if (isset($this->fieldConfiguration['options']['multiple'])) {
            $multiple = $this->fieldConfiguration['options']['multiple'];
        }

        if ($expanded) {
            $type = 'radio';
            if ($multiple) {
                $type = 'checkbox';
            }
            $typeOptions = $type;
        } else {
            if ($multiple) {
                $typeOptions = 'multiple';
            }
        }

        $this->formlyFieldConfiguration['type'] = $type;
        $this->formlyFieldConfiguration['templateOptions']['type'] = $typeOptions;

        if (isset($this->fieldConfiguration['options']['choices'])) {
            $choices = $this->fieldConfiguration['options']['choices'];
            $this->formlyFieldConfiguration['templateOptions']['options'] = $choices;
            unset($this->formlyFieldConfiguration['templateOptions']['choices']);
        }
    }
}
