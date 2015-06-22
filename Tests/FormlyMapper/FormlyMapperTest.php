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
        $csrfTokenManagerMock = $this->prophesize('Symfony\Component\Security\Csrf\CsrfTokenManagerInterface');

        $csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn('d44b121fc3524fe5cdc4f3feb31ceb78');

        $formlyMapper = new FormlyMapper();

        $formlyMapper->setCsrfTokenManager($csrfTokenManagerMock->reveal());

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

        $actual = $formlyMapper->map($configuration, 'new_user');

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
