<?php
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

    /**
     * @param FormFactory $dynamicFormFactory
     */
    public function setDynamicFormFactory(FormFactory $dynamicFormFactory)
    {
        $this->dynamicFormFactory = $dynamicFormFactory;
    }
}
