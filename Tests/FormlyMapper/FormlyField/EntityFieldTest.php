<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\EntityField;

class EntityFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityField
     */
    protected $formlyField;

    public function testIsAddingEntityInput()
    {
        $fieldConfiguration = [
            'name' => 'entity',
            'type' => 'entity',
            'class' => '',
            'options' => [
                'required' => true,
                'label' => 'Entity',
                'expanded' => false,
                'multiple' => false,
                'input' => true,
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Regex' => [
                    'pattern' => '^[0-9]{3}$',
                    'message' => 'Invalid entity Id',
                ],
            ],
        ];

        $expected = [
            'key' => 'entity',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'number',
                'label' => 'Entity',
                'required' => true,
                'pattern' => '^[0-9]{3}$',
                'expanded' => false,
                'multiple' => false,
                'input' => true,
            ],
            'validation' => [
                'messages' => 'Invalid entity Id',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsAddingEntitySelectChoice()
    {
        $fieldConfiguration = [
            'name' => 'entity',
            'type' => 'entity',
            'class' => '',
            'options' => [
                'required' => true,
                'label' => 'Entity',
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'entity',
            'type' => 'select',
            'templateOptions' => [
                'type' => 'select',
                'label' => 'Entity',
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsAddingEntitySelectMultipleChoice()
    {
        $fieldConfiguration = [
            'name' => 'entity',
            'type' => 'entity',
            'class' => '',
            'options' => [
                'required' => true,
                'label' => 'Entity',
                'expanded' => false,
                'multiple' => true,
                'choices' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'entity',
            'type' => 'select',
            'templateOptions' => [
                'type' => 'multiple',
                'label' => 'Entity',
                'required' => true,
                'expanded' => false,
                'multiple' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsAddingEntityRadioChoice()
    {
        $fieldConfiguration = [
            'name' => 'entity',
            'type' => 'entity',
            'class' => '',
            'options' => [
                'required' => true,
                'label' => 'Entity',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'entity',
            'type' => 'radio',
            'templateOptions' => [
                'type' => 'radio',
                'label' => 'Entity',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
                    ],
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsAddingEntityCheckboxChoice()
    {
        $fieldConfiguration = [
            'name' => 'entity',
            'type' => 'entity',
            'class' => '',
            'options' => [
                'required' => true,
                'label' => 'Entity',
                'expanded' => true,
                'multiple' => true,
                'choices' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
                    ],
                ],
            ],
        ];

        $expected = [
            'key' => 'entity',
            'type' => 'checkbox',
            'templateOptions' => [
                'type' => 'checkbox',
                'label' => 'Entity',
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                'options' => [
                    [
                        'value' => '1',
                        'text' => 'Entity 1',
                    ],
                    [
                        'value' => '2',
                        'text' => 'Entity 2',
                    ],
                    [
                        'value' => '3',
                        'text' => 'Entity 3',
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
        $this->formlyField = new EntityField();
    }
}
