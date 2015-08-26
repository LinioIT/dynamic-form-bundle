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
    public function getFieldType();

    /**
     * @return void
     */
    public function buildFieldTypeConfiguration();
}
