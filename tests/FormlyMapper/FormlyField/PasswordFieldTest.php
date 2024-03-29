<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\PasswordField;
use PHPUnit\Framework\TestCase;

class PasswordFieldTest extends TestCase
{
    /**
     * @var PasswordField
     */
    protected $formlyField;

    public function testIsAddingPasswordFields(): void
    {
        $fieldConfiguration = [
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'required' => true,
                'label' => 'Password',
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Regex' => [
                    'pattern' => '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$',
                    'message' => 'Password must have 1 capital letter, 1 lower case letter, 1 digit or special character and must be longer than 8 characters',
                ],
            ],
        ];

        $expected = [
            'key' => 'password',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'password',
                'label' => 'Password',
                'required' => true,
                'pattern' => '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$',
            ],
            'validation' => [
                'messages' => [
                    'regex' => 'Password must have 1 capital letter, 1 lower case letter, 1 digit or special character and must be longer than 8 characters',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new PasswordField();
    }
}
