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
                    'label' => 'Width',
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'width',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'number',
                    'label' => 'Width',
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

    public function testIsFormlyRangeConstraint()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $configuration = [
            'age' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                    'label' => 'Age',
                ],
                'validation' => [
                    'Symfony\Component\Validator\Constraints\Range' => [
                        'min' => 5,
                        'max' => 100,
                        'minMessage' => 'Min length minimum value should be at last {{ limit }}',
                        'maxMessage' => 'Max length maximum value should be at maximum {{ limit }}',
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
                    'label' => 'Age',
                    'required' => true,
                    'min' => '5',
                    'max' => '100',
                ],
                'validation' => [
                    'messages' => [
                        'min' => 'Min length minimum value should be at last {{ limit }}',
                        'max' => 'Max length maximum value should be at maximum {{ limit }}',
                    ],
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

    public function testIsFormlyRegexConstraint()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $configuration = [
            'age' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                    'label' => 'Age',
                ],
                'validation' => [
                    'Symfony\Component\Validator\Constraints\Regex' => [
                        'pattern' => '^[0-9]{2}$',
                        'message' => 'Invalid allowed age',
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
                    'label' => 'Age',
                    'required' => true,
                    'pattern' => '^[0-9]{2}$',
                ],
                'validation' => [
                    'messages' => 'Invalid allowed age',
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
                    'label' => 'Name',
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'name',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'text',
                    'label' => 'Name',
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

    public function testIsFormlyNotBlankConstraint()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $configuration = [
            'name' => [
                'type' => 'text',
                'options' => [
                    'required' => true,
                    'label' => 'Name',
                ],
                'validation' => [
                    'Symfony\Component\Validator\Constraints\NotBlank' => [
                        'message' => 'Name is mandatory',
                    ],
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'name',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'text',
                    'label' => 'Name',
                    'required' => true,
                ],
                'validation' => [
                    'messages' => 'Name is mandatory',
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
