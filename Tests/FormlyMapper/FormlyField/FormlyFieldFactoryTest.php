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

        $formlyFieldFactory = new FormlyFieldFactory();
        $formlyFieldFactory->has($alias);
    }

    public function testIsGettingTheFormlyFieldInstance()
    {
        $alias = 'number';

        $formlyFieldFactory = new FormlyFieldFactory();
        $formlyFieldFactory->getFormlyField($alias);
    }
}
