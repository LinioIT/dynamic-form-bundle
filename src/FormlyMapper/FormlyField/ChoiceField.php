<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class ChoiceField extends FormlyField
{
    /**
     * {@inheritdoc}
     */
    protected function getFieldType()
    {
        return 'select';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFieldTypeConfiguration(): void
    {
        $type = $this->getFieldType();

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
