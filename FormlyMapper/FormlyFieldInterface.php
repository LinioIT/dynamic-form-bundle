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
    public function generateCommonConfiguration();

    /**
     * @return array
     */
    public function getFieldConfiguration();
}
