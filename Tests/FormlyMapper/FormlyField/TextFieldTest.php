<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\TextField;

class TextFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TextField
     */
    protected $formlyField;

    public function testIsAddingTextFields()
    {
        $fieldConfiguration = [
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'required' => true,
                'label' => 'Name',
            ],
        ];

        $expected = [
            'key' => 'name',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'text',
                'label' => 'Name',
                'required' => true,
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function testIsNotBlankConstraint()
    {
        $fieldConfiguration = [
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'required' => true,
                'label' => 'Name',
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\NotBlank' => [
                    'message' => 'Name is mandatory',
                ],
            ],
        ];

        $expected = [
            'key' => 'name',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'text',
                'label' => 'Name',
                'required' => true,
            ],
            'validation' => [
                'messages' => 'Name is mandatory',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new TextField();
    }
}
