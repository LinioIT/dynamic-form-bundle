<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\EmailField;

class EmailFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EmailField
     */
    protected $formlyField;

    public function testIsAddingEmailFields(): void
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
                'messages' => [
                    'regex' => 'The email do not have the correct format',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new EmailField();
    }
}
