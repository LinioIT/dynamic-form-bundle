<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\Exception\InexistentFormlyFieldException;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyFieldInterface;

class FormlyFieldFactory
{
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
}
