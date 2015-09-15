<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\NumberField;

class NumberFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NumberField
     */
    protected $formlyField;

    public function testIsAddingNumberFields()
    {
        $fieldConfiguration = [
            'name' => 'width',
            'type' => 'number',
            'options' => [
                'required' => true,
                'label' => 'Width',
                'data' => 255,
            ],
        ];

        $expected = [
            'key' => 'width',
            'type' => 'input',
            'defaultValue' => 255,
            'templateOptions' => [
                'type' => 'number',
                'label' => 'Width',
                'required' => true,
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsRangeConstraint()
    {
        $fieldConfiguration = [
            'name' => 'age',
            'type' => 'number',
            'options' => [
                'required' => true,
                'label' => 'Age',
                'data' => 18,
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Range' => [
                    'min' => 18,
                    'max' => 100,
                    'minMessage' => 'Min length minimum value should be at last {{ limit }}',
                    'maxMessage' => 'Max length maximum value should be at maximum {{ limit }}',
                ],
            ],
        ];

        $expected = [
            'key' => 'age',
            'type' => 'input',
            'defaultValue' => 18,
            'templateOptions' => [
                'type' => 'number',
                'label' => 'Age',
                'required' => true,
                'min' => 18,
                'max' => 100,
            ],
            'validation' => [
                'messages' => [
                    'min' => 'Min length minimum value should be at last {{ limit }}',
                    'max' => 'Max length maximum value should be at maximum {{ limit }}',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsRegexConstraint()
    {
        $fieldConfiguration = [
            'name' => 'age',
            'type' => 'number',
            'options' => [
                'required' => true,
                'label' => 'Age',
                'data' => 18,
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Regex' => [
                    'pattern' => '^[0-9]{2}$',
                    'message' => 'Invalid allowed age',
                ],
            ],
        ];

        $expected = [
            'key' => 'age',
            'type' => 'input',
            'defaultValue' => 18,
            'templateOptions' => [
                'type' => 'number',
                'label' => 'Age',
                'required' => true,
                'pattern' => '^[0-9]{2}$',
            ],
            'validation' => [
                'messages' => [
                    'regex' => 'Invalid allowed age',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new NumberField();
    }
}
