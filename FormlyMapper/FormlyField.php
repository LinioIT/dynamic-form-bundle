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

            if (isset($this->fieldConfiguration['options']['label'])) {
                $templateOptions['label'] = ucfirst($this->fieldConfiguration['options']['label']);
            } else {
                $templateOptions['label'] = ucfirst($this->fieldConfiguration['name']);
            }

            $this->formlyFieldConfiguration['templateOptions'] = ($templateOptions);
        }
    }

    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
    }
}
