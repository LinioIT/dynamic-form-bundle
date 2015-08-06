<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\EmailField;

class EmailFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EmailField
     */
    protected $formlyField;

    public function testIsAddingEmailFields()
    {
        $fieldConfiguration = [
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'required' => true,
                'label' => 'Email',
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Regex' => [
                    'pattern' => '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i',
                    'message' => 'The email do not have the correct format',
                ],
            ],
        ];

        $expected = [
            'key' => 'email',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'email',
                'label' => 'Email',
                'required' => true,
                'pattern' => '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i',
            ],
            'validation' => [
                'messages' => 'The email do not have the correct format',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new EmailField();
    }
}
