<?php

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyFields;

use Linio\DynamicFormBundle\Exception\InexistentFormlyFieldException;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class FormlyFieldFactory
{

    /**
     * @param string $type
     *
     * @return FormlyField
     *
     * @throws \ReflectionException
     * @throws InexistentFormlyFieldException
     */
    public function getFormField($type)
    {
        $formlyFieldClassName = $this->getFullClassName($type);

        $fieldClass = new \ReflectionClass($formlyFieldClassName);

        if (!$fieldClass->isSubclassOf(__NAMESPACE__ . '\FormlyField')) {
            throw new InexistentFormlyFieldException();
        }

        $fieldInstance = $fieldClass->newInstance();

        return $fieldInstance;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected function getFullClassName($type)
    {
        $className = [];

        $className[] = __NAMESPACE__ . '\\';
        $classNameWords = explode(' ', $type);

        foreach ($classNameWords as $word) {
            $className[] = ucfirst($word);
        }

        $className[] = 'Field';

        return implode('', $className);
    }
}
