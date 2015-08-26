<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

interface FormlyFieldInterface
{
    /**
     * @param array $configuration
     */
    public function setFieldConfiguration(array $configuration);

    /**
     * @return array
     */
    public function getFormlyFieldConfiguration();

    /**
     * @return string
     */
    public function getTemplateFieldType();

    /**
     * @return void
     */
    public function generateSpecificConfiguration();
}
