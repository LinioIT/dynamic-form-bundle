<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\NumberField;
use PHPUnit\Framework\TestCase;

class NumberFieldTest extends TestCase
{
    /**
     * @var NumberField
     */
    protected $formlyField;

    public function testIsAddingNumberFields(): void
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

    public function testIsRangeConstraint(): void
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

    public function testIsRegexConstraint(): void
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

    public function setup(): void
    {
        $this->formlyField = new NumberField();
    }
}
