<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\HiddenField;

class HiddenFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HiddenField
     */
    protected $formlyField;

    public function testIsAddingHiddenFields(): void
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
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new HiddenField();
    }
}
