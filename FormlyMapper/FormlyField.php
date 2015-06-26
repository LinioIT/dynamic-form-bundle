<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

class FormlyField implements FormlyFieldInterface
{
    protected $fieldConfiguration;

    /**
     * @param array $fieldConfiguration
     */
    public function setFieldConfiguration(array $fieldConfiguration)
    {
        $this->fieldConfiguration = $fieldConfiguration;
    }

    /**
     * @return array
     */
    public function getFieldConfiguration()
    {
    }
}
