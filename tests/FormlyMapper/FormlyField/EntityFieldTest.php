<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\EntityField;
use PHPUnit\Framework\TestCase;

class EntityFieldTest extends TestCase
{
    /**
     * @var EntityField
     */
    protected $formlyField;

    public function testIsAddingEntity(): void
    {
        $fieldConfiguration = [
            'name' => 'entity',
            'type' => 'entity',
            'class' => '',
            'options' => [
                'required' => true,
                'label' => 'Entity',
                'expanded' => false,
                'multiple' => false,
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Regex' => [
                    'pattern' => '^[0-9]{3}$',
                    'message' => 'Invalid entity Id',
                ],
            ],
        ];

        $expected = [
            'key' => 'entity',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'hidden',
                'label' => 'Entity',
                'required' => true,
                'pattern' => '^[0-9]{3}$',
                'expanded' => false,
                'multiple' => false,
            ],
            'validation' => [
                'messages' => [
                    'regex' => 'Invalid entity Id',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new EntityField();
    }
}
