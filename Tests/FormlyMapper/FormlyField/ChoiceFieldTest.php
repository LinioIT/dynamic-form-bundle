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
                'expanded' => false,
                'multiple' => false,
                'choices' => [
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
        $actual = $this->formlyField->getFormlyFieldConfiguration();

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
                'expanded' => false,
                'multiple' => true,
                'choices' => [
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
                'expanded' => false,
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
        $actual = $this->formlyField->getFormlyFieldConfiguration();

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
                'multiple' => false,
                'choices' => [
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
        $actual = $this->formlyField->getFormlyFieldConfiguration();

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
                'choices' => [
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
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new ChoiceField();
    }
}
