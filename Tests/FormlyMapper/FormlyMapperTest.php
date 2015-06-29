<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper;

use Linio\DynamicFormBundle\FormlyMapper\FormlyMapper;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * @codeCoverageIgnore
 */
class FormlyMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testIsGeneratingConfigurationWithNumberField()
    {
        $csrfTokenManagerMock = $this->prophesize('Symfony\Component\Security\Csrf\CsrfTokenManagerInterface');

        $csrfToken = new CsrfToken('new_user', 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw');

        $csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($csrfToken);

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
        ];

        $actual = $formlyMapper->map($configuration, 'new_user');

        $expected = [
            [
                'key' => 'width',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'number',
                    'label' => 'Ancho',
                    'required' => true,
                ],
            ],
            [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw',
            ],
        ];

        $this->assertEquals($expected, $actual);
    }
}
