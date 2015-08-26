<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\TimeField;

class TimeFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TimeField
     */
    protected $formlyField;

    public function testIsAddingTimeFields()
    {
        $fieldConfiguration = [
            'name' => 'time',
            'type' => 'time',
            'options' => [
                'required' => true,
                'label' => 'Time',
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Regex' => [
                    'pattern' => '^[0-9]{2}\:[0-9]{2}\:[0-9]{2}$',
                    'message' => 'The time must follow the pattern hh:mm:ss',
                ],
            ],
        ];

        $expected = [
            'key' => 'time',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'time',
                'label' => 'Time',
                'required' => true,
                'pattern' => '^[0-9]{2}\:[0-9]{2}\:[0-9]{2}$',
            ],
            'validation' => [
                'messages' => 'The time must follow the pattern hh:mm:ss',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new TimeField();
    }
}
