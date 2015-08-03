<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

class FormlyField implements FormlyFieldInterface
{
    protected $fieldConfiguration;

    protected $formlyFieldConfiguration;

    /**
     * @param array $fieldConfiguration
     */
    public function setFieldConfiguration(array $fieldConfiguration)
    {
        $this->fieldConfiguration = $fieldConfiguration;
    }

    /**
     * This function generates the common configuration for all field types.
     */
    public function generateCommonConfiguration()
    {
        $this->formlyFieldConfiguration = [];

        $this->formlyFieldConfiguration['key'] = $this->fieldConfiguration['name'];
        $this->formlyFieldConfiguration['type'] = 'input';

        $templateOptions = [];

        if (isset($this->fieldConfiguration['options'])) {
            foreach ($this->fieldConfiguration['options'] as $option => $value) {
                $templateOptions[$option] = $value;
            }

            $templateOptions['label'] = ucfirst($this->fieldConfiguration['name']);
            if (isset($this->fieldConfiguration['options']['label'])) {
                $templateOptions['label'] = ucfirst($this->fieldConfiguration['options']['label']);
            }

            $this->formlyFieldConfiguration['templateOptions'] = ($templateOptions);
        }

        if (isset($this->fieldConfiguration['validation'])) {
            $validation = $this->fieldConfiguration['validation'];

            if (isset($validation['Symfony\Component\Validator\Constraints\NotBlank'])) {
                $constraint = $validation['Symfony\Component\Validator\Constraints\NotBlank'];
                if (isset ($constraint['message'])) {
                    $this->formlyFieldConfiguration['validation']['messages'] = $constraint['message'];
                }
            }

            if (isset($validation['Symfony\Component\Validator\Constraints\Regex'])) {
                $constraint = $validation['Symfony\Component\Validator\Constraints\Regex'];
                $this->formlyFieldConfiguration['templateOptions']['pattern'] = $constraint['pattern'];
                if (isset ($constraint['message'])) {
                    $this->formlyFieldConfiguration['validation']['messages'] = $constraint['message'];
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
    }
}
