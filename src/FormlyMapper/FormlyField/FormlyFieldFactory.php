<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

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
     * @param int                  $alias
     */
    public function addFormlyField($alias, FormlyFieldInterface $formlyField): void
    {
        $this->formlyFields[$alias] = $formlyField;
    }

    /**
     * @param int $alias
     *
     * @return bool
     */
    public function has($alias)
    {
        return isset($this->formlyFields[$alias]);
    }

    /**
     * @param int $alias
     *
     * @return FormlyFieldInterface
     */
    public function getFormlyField($alias)
    {
        if ($this->has($alias)) {
            return $this->formlyFields[$alias];
        }

        return $this->formlyFields['default'];
    }
}
