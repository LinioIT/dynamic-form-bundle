<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper;

interface FormlyFieldInterface
{
    public function setFieldConfiguration(array $configuration);

    /**
     * @return array
     */
    public function getFormlyFieldConfiguration();
}
