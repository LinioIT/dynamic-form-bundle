<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\DateField;

class DateFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateField
     */
    protected $formlyField;

    public function testIsAddingTextareaFields()
    {
        $fieldConfiguration = [
            'name' => 'birthday',
            'type' => 'date',
            'options' => [
                'required' => true,
                'label' => 'Birthday',
            ],
        ];

        $expected = [
            'key' => 'birthday',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'date',
                'label' => 'Birthday',
                'required' => true,
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new DateField();
    }
}
