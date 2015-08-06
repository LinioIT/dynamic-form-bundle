<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\TextareaField;

class TextareaFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TextareaField
     */
    protected $formlyField;

    public function testIsAddingTextareaFields()
    {
        $fieldConfiguration = [
            'name' => 'comments',
            'type' => 'textarea',
            'options' => [
                'required' => true,
                'label' => 'Comments',
            ],
        ];

        $expected = [
            'key' => 'comments',
            'type' => 'textarea',
            'templateOptions' => [
                'type' => 'textarea',
                'label' => 'Comments',
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
        $this->formlyField = new TextareaField();
    }
}
