<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\DateField;

class DateFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateField
     */
    protected $formlyField;

    public function testIsAddingDateFields()
    {
        $fieldConfiguration = [
            'name' => 'birthday',
            'type' => 'date',
            'options' => [
                'required' => true,
                'label' => 'Birthday',
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Regex' => [
                    'pattern' => '^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$',
                    'message' => 'The birthday field must follow the pattern "yyyy-MM-dd"',
                ],
            ],
        ];

        $expected = [
            'key' => 'birthday',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'date',
                'label' => 'Birthday',
                'required' => true,
                'pattern' => '^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$',
            ],
            'validation' => [
                'messages' => 'The birthday field must follow the pattern "yyyy-MM-dd"',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new DateField();
    }
}
