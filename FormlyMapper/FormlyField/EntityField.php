<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class EntityField extends FormlyField
{
    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
        $type = 'select';
        $typeOptions = $type;
        $expanded = false;
        $multiple = false;

        if (isset($this->fieldConfiguration['options']['input']) && $this->fieldConfiguration['options']['input'] === true){
            $type = 'input';
            $typeOptions = 'number';
        } else {
            if (isset($this->fieldConfiguration['options']['expanded'])) {
                $expanded = $this->fieldConfiguration['options']['expanded'];
            }

            if (isset($this->fieldConfiguration['options']['multiple'])) {
                $multiple = $this->fieldConfiguration['options']['multiple'];
            }

            if ($expanded === true) {
                $type = 'radio';
                if ($multiple === true) {
                    $type = 'checkbox';
                }
                $typeOptions = $type;
            } else {
                if ($multiple === true) {
                    $typeOptions = 'multiple';
                }
            }
        }

        $this->formlyFieldConfiguration['type'] = $type;
        $this->formlyFieldConfiguration['templateOptions']['type'] = $typeOptions;

        if (isset($this->fieldConfiguration['options']['choices'])) {
            $choices = $this->fieldConfiguration['options']['choices'];

            $this->formlyFieldConfiguration['templateOptions']['options'] = $choices;
            unset($this->formlyFieldConfiguration['templateOptions']['choices']);
        }

        return $this->formlyFieldConfiguration;
    }

}
