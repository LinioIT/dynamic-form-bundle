<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle;

use Linio\DynamicFormBundle\Form\FormFactory;

/**
 * @codeCoverageIgnore
 */
trait DynamicFormAware
{
    /**
     * @var FormFactory
     */
    protected $dynamicFormFactory;

    /**
     * @return FormFactory
     */
    public function getDynamicFormFactory()
    {
        return $this->dynamicFormFactory;
    }

    public function setDynamicFormFactory(FormFactory $dynamicFormFactory): void
    {
        $this->dynamicFormFactory = $dynamicFormFactory;
    }
}
