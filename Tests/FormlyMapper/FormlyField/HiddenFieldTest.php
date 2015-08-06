<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\HiddenField;

class HiddenFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HiddenField
     */
    protected $formlyField;

    public function testIsAddingHiddenFields()
    {
        $fieldConfiguration = [
            'name' => 'id',
            'type' => 'hidden',
            'options' => [
                'required' => true,
                'label' => 'Id',
            ],
        ];

        $expected = [
            'key' => 'id',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'hidden',
                'label' => 'Id',
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
        $this->formlyField = new HiddenField();
    }
}
