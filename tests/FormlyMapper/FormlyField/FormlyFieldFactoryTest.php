<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\DefaultField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField\FormlyFieldFactory;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField\NumberField;

class FormlyFieldFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIsHasTheFormlyField(): void
    {
        $alias = 'number';
        $formlyField = new NumberField();

        $formlyFieldFactory = new FormlyFieldFactory();
        $formlyFieldFactory->addFormlyField($alias, $formlyField);

        $actual = $formlyFieldFactory->has($alias);

        $this->assertTrue($actual);
    }

    public function testIsGettingSpecificFormlyFieldInstance(): void
    {
        $alias = 'number';
        $formlyField = new NumberField();

        $formlyFieldFactory = new FormlyFieldFactory();
        $formlyFieldFactory->addFormlyField($alias, $formlyField);

        $actual = $formlyFieldFactory->getFormlyField($alias);

        $this->assertInstanceOf('Linio\DynamicFormBundle\FormlyMapper\FormlyFieldInterface', $actual);
    }

    public function testIsGettingDefaultFormlyFieldInstance(): void
    {
        $formlyFieldFactory = new FormlyFieldFactory();

        $numberField = new NumberField();
        $formlyFieldFactory->addFormlyField('number', $numberField);

        $dafaultField = new DefaultField();
        $formlyFieldFactory->addFormlyField('default', $dafaultField);

        $actual = $formlyFieldFactory->getFormlyField('file');

        $this->assertInstanceOf('Linio\DynamicFormBundle\FormlyMapper\FormlyFieldInterface', $actual);
    }
}
