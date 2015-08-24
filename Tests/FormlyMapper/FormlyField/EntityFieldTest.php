<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\EntityField;

class EntityFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityField
     */
    protected $formlyField;

    public function testIsAddingEntity()
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
                'messages' => 'Invalid entity Id',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new EntityField();
    }
}
