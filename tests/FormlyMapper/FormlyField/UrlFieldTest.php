<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\UrlField;

class UrlFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UrlField
     */
    protected $formlyField;

    public function testIsAddingUrlFields(): void
    {
        $fieldConfiguration = [
            'name' => 'url',
            'type' => 'url',
            'options' => [
                'required' => true,
                'label' => 'URL',
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\Url' => [
                    'message' => 'The url do not have the correct format',
                ],
            ],
        ];

        $expected = [
            'key' => 'url',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'url',
                'label' => 'URL',
                'required' => true,
            ],
            'validation' => [
                'messages' => [
                    'url' => 'The url do not have the correct format',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new UrlField();
    }
}
