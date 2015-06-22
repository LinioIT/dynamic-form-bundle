<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper;

use Linio\DynamicFormBundle\FormlyMapper\FormlyMapper;

/**
 * @codeCoverageIgnore
 */
class FormlyMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testIsGettingFormlyJsonConfiguration()
    {
        $formlyMapper = new FormlyMapper();

        $configuration = [
            'width' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                    'label' => 'Ancho',
                ],
            ],
            'height' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                ],
            ],
        ];

        $actual = $formlyMapper->map($configuration);

        $expected = [
            [
                'key' => 'width',
                'type' => 'input',
                'templateOptions' => [
                    'label' => 'Ancho',
                    'placeholder' => 'Ancho',
                    'required' => true,
                ],
            ],
            [
                'key' => 'height',
                'type' => 'input',
                'templateOptions' => [
                    'label' => 'Height',
                    'placeholder' => 'Height',
                    'required' => true,
                ],
            ],
        ];

        $this->assertEquals($expected, $actual);
    }
}
