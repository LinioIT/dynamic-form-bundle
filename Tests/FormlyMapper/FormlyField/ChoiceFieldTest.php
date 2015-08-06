<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\ChoiceField;

class ChoiceFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ChoiceField
     */
    protected $formlyField;

    public function testIsAddingSelectChoice()
    {
        $fieldConfiguration = [
            'name' => 'option',
            'type' => 'choice',
            'options' => [
                'required' => true,
                'label' => 'Option',
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'option',
            'type' => 'select',
            'templateOptions' => [
                'type' => 'select',
                'label' => 'Option',
                'required' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsAddingSelectMultipleChoice()
    {
        $fieldConfiguration = [
            'name' => 'option',
            'type' => 'choice',
            'options' => [
                'required' => true,
                'label' => 'Option',
                'multiple' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'option',
            'type' => 'select',
            'templateOptions' => [
                'type' => 'multiple',
                'label' => 'Option',
                'required' => true,
                'multiple' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsAddingRadioChoice()
    {
        $fieldConfiguration = [
            'name' => 'option',
            'type' => 'choice',
            'options' => [
                'required' => true,
                'label' => 'Option',
                'expanded' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'option',
            'type' => 'radio',
            'templateOptions' => [
                'type' => 'radio',
                'label' => 'Option',
                'required' => true,
                'expanded' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsNoAddingRadioChoice()
    {
        $fieldConfiguration = [
            'name' => 'option',
            'type' => 'choice',
            'options' => [
                'required' => true,
                'label' => 'Option',
                'expanded' => false,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'option',
            'type' => 'select',
            'templateOptions' => [
                'type' => 'select',
                'label' => 'Option',
                'required' => true,
                'expanded' => false,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsAddingCheckboxChoice()
    {
        $fieldConfiguration = [
            'name' => 'option',
            'type' => 'choice',
            'options' => [
                'required' => true,
                'label' => 'Option',
                'expanded' => true,
                'multiple' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'option',
            'type' => 'checkbox',
            'templateOptions' => [
                'type' => 'checkbox',
                'label' => 'Option',
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsNoAddingCheckboxChoice()
    {
        $fieldConfiguration = [
            'name' => 'option',
            'type' => 'choice',
            'options' => [
                'required' => true,
                'label' => 'Option',
                'expanded' => true,
                'multiple' => false,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'option',
            'type' => 'radio',
            'templateOptions' => [
                'type' => 'radio',
                'label' => 'Option',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Option 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Option 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Option 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new ChoiceField();
    }
}
