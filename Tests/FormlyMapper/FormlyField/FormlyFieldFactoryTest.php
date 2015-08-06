<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\FormlyFieldFactory;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField\NumberField;

class FormlyFieldFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIsAddingOneFormlyField()
    {
        $alias = 'number';
        $formlyField = new NumberField();

        $formlyFieldFactory = new FormlyFieldFactory();
        $formlyFieldFactory->addFormlyField($alias, $formlyField);
    }

    public function testIsHasTheFormlyField()
    {
        $alias = 'number';
        $formlyField = new NumberField();
        $formlyFieldFactory = new FormlyFieldFactory();
        $formlyFieldFactory->addFormlyField($alias, $formlyField);
        $formlyFieldFactory->has($alias);
    }

    public function testIsGettingTheFormlyFieldInstance()
    {
        $alias = 'number';
        $formlyField = new NumberField();

        $formlyFieldFactory = new FormlyFieldFactory();
        $formlyFieldFactory->addFormlyField($alias, $formlyField);
        $formlyFieldFactory->getFormlyField($alias);
    }
}
