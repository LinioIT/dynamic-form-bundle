<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\TimeField;
use PHPUnit\Framework\TestCase;

class TimeFieldTest extends TestCase
{
    /**
     * @var TimeField
     */
    protected $formlyField;

    public function testIsAddingTimeFields(): void
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
                'messages' => [
                    'regex' => 'The time must follow the pattern hh:mm:ss',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new TimeField();
    }
}
