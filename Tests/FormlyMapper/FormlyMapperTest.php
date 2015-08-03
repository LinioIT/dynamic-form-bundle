<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper;

use Linio\DynamicFormBundle\FormlyMapper\FormlyMapper;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class FormlyMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testIsFormlyNumberField()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $configuration = [
            'width' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                    'label' => 'Ancho',
                ],
            ],
        ];

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

        $csrfToken = new CsrfToken('new_user', 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw');

        $csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($csrfToken);

        $formlyMapper = new FormlyMapper();
        $formlyMapper->setCsrfTokenManager($csrfTokenManagerMock->reveal());

        $actual = $formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyNumberRangeConstraint()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $configuration = [
            'age' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                    'label' => 'Edad',
                ],
                'validation' => [
                    'Symfony\Component\Validator\Constraints\Range' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'age',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'number',
                    'label' => 'Edad',
                    'required' => true,
                    'min' => '5',
                    'max' => '100',
                ],
            ],
            [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw',
            ],
        ];

        $csrfToken = new CsrfToken('new_user', 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw');

        $csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($csrfToken);

        $formlyMapper = new FormlyMapper();
        $formlyMapper->setCsrfTokenManager($csrfTokenManagerMock->reveal());

        $actual = $formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyNumberRegexConstraint()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $configuration = [
            'age' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                    'label' => 'Edad',
                ],
                'validation' => [
                    'Symfony\Component\Validator\Constraints\Regex' => [
                        'pattern' => '^[0-9]{2}$',
                    ],
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'age',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'number',
                    'label' => 'Edad',
                    'required' => true,
                    'pattern' => '^[0-9]{2}$',
                ],
            ],
            [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw',
            ],
        ];

        $csrfToken = new CsrfToken('new_user', 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw');

        $csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($csrfToken);

        $formlyMapper = new FormlyMapper();
        $formlyMapper->setCsrfTokenManager($csrfTokenManagerMock->reveal());

        $actual = $formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyTextField()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $configuration = [
            'name' => [
                'type' => 'text',
                'options' => [
                    'required' => true,
                    'label' => 'Nombre',
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'name',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'text',
                    'label' => 'Nombre',
                    'required' => true,
                ],
            ],
            [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw',
            ],
        ];

        $csrfToken = new CsrfToken('new_user', 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw');

        $csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($csrfToken);

        $formlyMapper = new FormlyMapper();
        $formlyMapper->setCsrfTokenManager($csrfTokenManagerMock->reveal());

        $actual = $formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }
}
