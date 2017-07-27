<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\FileField;

class FileFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileField
     */
    protected $formlyField;

    public function testIsAddingFileFields(): void
    {
        $fieldConfiguration = [
            'name' => 'file',
            'type' => 'file',
            'options' => [
                'required' => true,
                'label' => 'File',
            ],
        ];

        $expected = [
            'key' => 'file',
            'type' => 'file',
            'templateOptions' => [
                'type' => 'file',
                'label' => 'File',
                'required' => true,
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new FileField();
    }
}
