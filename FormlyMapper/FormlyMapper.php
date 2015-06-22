<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

class FormlyMapper
{
    /**
     * @param array $configuration
     *
     * @return array
     */
    public function map(array $configuration)
    {
        foreach ($configuration as $field => $config) {
            $fieldConfiguration = [];

            $fieldConfiguration['key'] = $field;
            $fieldConfiguration['type'] = 'input';

            if (isset($config['options'])) {
                $templateOptions = [];

                if (isset($config['options']['label'])) {
                    $templateOptions['label'] = $config['options']['label'];
                    $templateOptions['placeholder'] = $config['options']['label'];
                } else {
                    $templateOptions['label'] = ucfirst($field);
                    $templateOptions['placeholder'] = ucfirst($field);
                }

                foreach ($config['options'] as $option => $value) {
                    $templateOptions[$option] = $value;
                }

                $fieldConfiguration['templateOptions'] = ($templateOptions);
            }

            $formlyConfiguration[] = $fieldConfiguration;
        }

        return $formlyConfiguration;
    }
}
