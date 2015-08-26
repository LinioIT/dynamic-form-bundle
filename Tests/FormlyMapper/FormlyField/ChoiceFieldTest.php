<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\ChoiceField;

class ChoiceFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ChoiceField
     */
    protected $formlyField;

    /**
     * @var array
     */
    protected $fieldConfiguration = [];

    /**
     * @var array
     */
    protected $expected = [];

    public function testIsAddingSelectChoice()
    {
        $this->formlyField->setFieldConfiguration($this->fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($this->expected, $actual);
    }

    public function testIsAddingSelectMultipleChoice()
    {
        $this->fieldConfiguration['options']['multiple'] = true;

        $this->expected['templateOptions']['type'] = 'multiple';
        $this->expected['templateOptions']['multiple'] = true;

        $this->formlyField->setFieldConfiguration($this->fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($this->expected, $actual);
    }

    public function testIsAddingRadioChoice()
    {
        $this->fieldConfiguration['options']['expanded'] = true;

        $this->expected['type'] = 'radio';
        $this->expected['templateOptions']['type'] = 'radio';
        $this->expected['templateOptions']['expanded'] = true;

        $this->formlyField->setFieldConfiguration($this->fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($this->expected, $actual);
    }

    public function testIsAddingCheckboxChoice()
    {
        $this->fieldConfiguration['options']['expanded'] = true;
        $this->fieldConfiguration['options']['multiple'] = true;

        $this->expected['type'] = 'checkbox';
        $this->expected['templateOptions']['type'] = 'checkbox';
        $this->expected['templateOptions']['expanded'] = true;
        $this->expected['templateOptions']['multiple'] = true;

        $this->formlyField->setFieldConfiguration($this->fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($this->expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new ChoiceField();

        $this->fieldConfiguration = [
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

        $this->expected = [
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
    }
}
