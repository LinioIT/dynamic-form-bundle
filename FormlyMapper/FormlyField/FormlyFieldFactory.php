<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyFieldInterface;

class FormlyFieldFactory
{
    /**
     * @var array
     */
    protected $fieldConfiguration;

    /**
     * @var array
     */
    protected $formlyFieldConfiguration;

    /**
     * @var FormlyFieldInterface[]
     */
    protected $formlyFields;

    /**
     * @param                      $alias
     * @param FormlyFieldInterface $formlyField
     */
    public function addFormlyField($alias, FormlyFieldInterface $formlyField)
    {
        $this->formlyFields[$alias] = $formlyField;
    }

    /**
     * @param $alias
     *
     * @return bool
     */
    public function has($alias)
    {
        return isset($this->formlyFields[$alias]);
    }

    /**
     * @param $alias
     *
     * @return FormlyFieldInterface
     */
    public function getFormlyField($alias)
    {
        return $this->formlyFields[$alias];
    }
}
