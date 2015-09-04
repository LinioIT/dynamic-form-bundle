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
            'validation' => [
                'Symfony\Component\Validator\Constraints\NotBlank' => [
                    'message' => 'Comments field is mandatory',
                ],
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
            'validation' => [
                'messages' => [
                    'blank' => 'Comments field is mandatory',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new TextareaField();
    }
}
