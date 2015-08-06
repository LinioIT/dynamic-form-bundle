<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\FileField;

class FileFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileField
     */
    protected $formlyField;

    public function testIsAddingFileFields()
    {
        $fieldConfiguration = [
            'name' => 'file',
            'type' => 'file',
            'options' => [
                'required' => true,
                'label' => 'File',
            ],
        ];

        $expected = [
            'key' => 'file',
            'type' => 'file',
            'templateOptions' => [
                'type' => 'file',
                'label' => 'File',
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
        $this->formlyField = new FileField();
    }
}
