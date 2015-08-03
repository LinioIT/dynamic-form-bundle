<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper;

use Linio\DynamicFormBundle\FormlyMapper\FormlyMapper;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class FormlyMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy
     */
    protected $csrfTokenManagerMock;

    /**
     * @var CsrfToken
     */
    protected $csrfToken;

    /**
     * @var FormlyMapper
     */
    protected $formlyMapper;

    public function testIsFormlyNumberField()
    {
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

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyRangeConstraint()
    {
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

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyRegexConstraint()
    {
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

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyTextField()
    {
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

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyNotBlankConstraint()
    {
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

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyTextArea()
    {
        $configuration = [
            'name' => [
                'type' => 'textarea',
                'options' => [
                    'required' => true,
                    'label' => 'Name',
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'name',
                'type' => 'textarea',
                'templateOptions' => [
                    'type' => 'textarea',
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

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyDate()
    {
        $configuration = [
            'name' => [
                'type' => 'date',
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
                    'type' => 'date',
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

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function testIsFormlyCheckbox()
    {
        $configuration = [
            'name' => [
                'type' => 'checkbox',
                'options' => [
                    'required' => true,
                    'label' => 'Name',
                ],
            ],
        ];

        $expected = [
            [
                'key' => 'name',
                'type' => 'checkbox',
                'templateOptions' => [
                    'type' => 'checkbox',
                    'label' => 'Name',
                    'required' => true,
                    'options' => [],
                ],
            ],
            [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw',
            ],
        ];

        $this->csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $actual = $this->formlyMapper->map($configuration, 'new_user');

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);
        $this->csrfToken = new CsrfToken('new_user', 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw');

        $this->formlyMapper = new FormlyMapper();
    }
}
