<?php

namespace Linio\DynamicFormBundle\Tests\Form\FormFactoryTest;

use Linio\DynamicFormBundle\Form\FormFactory;

use Prophecy\Argument;
use Symfony\Component\Validator\Constraints\True;
use Linio\Frontend\CustomerBundle\Form\DataTransformer\BornDateTransformer;

/**
 * @codeCoverageIgnore
 */
class FormFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Linio\DynamicFormBundle\Exception\InexistentFormException
     */
    public function testIsThrowingExceptionWhenCreatingAnInexistentForm()
    {
        $formFactory = new FormFactory();
        $formFactory->setConfiguration(['foo' => []]);
        $formFactory->createForm('bar');
    }

    public function testIsCreatingASimpleForm()
    {
        $formConfiguration = [
            'foo' => [
                'field1' => [
                    'enabled' => true,
                    'type' => 'field1_type',
                    'options' => ['field1_options'],
                ],
                'field2' => [
                    'enabled' => false,
                    'type' => 'field2_type',
                ],
            ],
        ];

        $formData = 'form_foo_data';
        $formOptions = 'form_foo_options';

        $formBuilderMock = $this->prophesize('\Symfony\Component\Form\FormBuilder');
        $formBuilderMock->create('field1', 'field1_type', ['field1_options'])
            ->shouldBeCalled()
            ->willReturn('field1_instance');

        $formBuilderMock->add('field1_instance')
            ->shouldBeCalled();

        $formBuilderMock->getForm()
            ->willReturn('foo_form');

        $formFactoryMock = $this->prophesize('\Symfony\Component\Form\FormFactory');
        $formFactoryMock->createBuilder('form', ['foo_form_data'], ['foo_form_options'])
            ->shouldBeCalled()
            ->willReturn($formBuilderMock->reveal());

        $formFactory = new FormFactory();
        $formFactory->setFormFactory($formFactoryMock->reveal());
        $formFactory->setConfiguration($formConfiguration);

        $actual = $formFactory->createForm('foo', ['foo_form_data'], ['foo_form_options']);

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsCreatingFormWithValidators()
    {
        $formConfiguration = [
            'foo' => [
                'field1' => [
                    'enabled' => true,
                    'type' => 'field1_type',
                    'validators' => [
                        'Symfony\Component\Validator\Constraints\True' => [
                            'message' => 'The token is invalid.',
                        ],
                    ],
                ],
            ],
        ];

        $expectedFieldOptions = [
            'constraints' => [
                new True(['message' => 'The token is invalid.'])
            ],
        ];

        $formBuilderMock = $this->prophesize('\Symfony\Component\Form\FormBuilder');
        $formBuilderMock->create('field1', 'field1_type', $expectedFieldOptions)
            ->shouldBeCalled()
            ->willReturn('field1_instance');

        $formBuilderMock->add('field1_instance')
            ->shouldBeCalled();

        $formBuilderMock->getForm()
            ->willReturn('foo_form');

        $formFactoryMock = $this->prophesize('\Symfony\Component\Form\FormFactory');
        $formFactoryMock->createBuilder('form', [], [])
            ->shouldBeCalled()
            ->willReturn($formBuilderMock->reveal());

        $formFactory = new FormFactory();
        $formFactory->setFormFactory($formFactoryMock->reveal());
        $formFactory->setConfiguration($formConfiguration);

        $formFactory->createForm('foo');
    }

    public function testIsCreatingFormWithTransformers()
    {
        $formConfiguration = [
            'foo' => [
                'field1' => [
                    'enabled' => true,
                    'type' => 'field1_type',
                    'transformer' => [
                        'class' => 'Linio\DynamicFormBundle\Tests\Form\FormFactoryTest\MockTransformer',
                        'calls' => [
                            ['setUserFormat', ['d/m/Y']],
                            ["setInputFormat", ['Y-m-d']]
                        ],
                    ],
                ],
            ],
        ];

        $expectedFieldOptions = [];

        $bornDateTransformer = new $formConfiguration['foo']['field1']['transformer']['class']();
        $bornDateTransformer->setUserFormat(['d/m/Y']);
        $bornDateTransformer->setInputFormat(['Y-m-d']);

        $formFactoryMock = $this->prophesize('\Symfony\Component\Form\FormFactory');
        $formBuilderMock = $this->prophesize('\Symfony\Component\Form\FormBuilder');
        $fieldOneMock = $this->prophesize('\Symfony\Component\Form\FormBuilder');

        $formFactory = new FormFactory();
        $formFactory->setFormFactory($formFactoryMock->reveal());
        $formFactory->setConfiguration($formConfiguration);

        $formFactoryMock->createBuilder('form', [], [])
            ->shouldBeCalled()
            ->willReturn($formBuilderMock->reveal());

        $formBuilderMock->create('field1', 'field1_type', $expectedFieldOptions)
            ->shouldBeCalled()
            ->willReturn($fieldOneMock->reveal());

        $fieldOneMock->addModelTransformer($bornDateTransformer)
            ->shouldBeCalled();

        $formBuilderMock->add($fieldOneMock->reveal())
            ->shouldBeCalledTimes(1);

        $formBuilderMock->getForm()
            ->willReturn('foo_form');

        $actual = $formFactory->createForm('foo');

        $this->assertEquals('foo_form', $actual);
    }

    /**
     * @expectedException \Linio\DynamicFormBundle\Exception\InexistentFormException
     */
    public function testIsThrowingExceptionForInexistentForms()
    {
        $dynamicFormFactory = new FormFactory();
        $dynamicFormFactory->setConfiguration([
            'foo' => [
                'email' => [
                    'enabled' => true,
                    'type' => 'email'
                ],
                'password' => [
                    'enabled' => true,
                    'type' => 'password'
                ],
            ],
        ]);

        $actual = $dynamicFormFactory->createForm('nope', [], []);
    }

    public function testIsGettingJsonConfiguration()
    {
        $dynamicFormFactory = new FormFactory();
        $dynamicFormFactory->setConfiguration([
            'john' => [
                'email' => [
                    'enabled' => true,
                    'type' => 'email'
                ],
                'password' => [
                    'enabled' => false,
                    'type' => 'password'
                ],
            ]
        ]);

        $actual = $dynamicFormFactory->getJsonConfiguration('john');

        $this->assertJsonStringEqualsJsonString('{"email":{"enabled":true,"type":"email"},"password":{"enabled":false,"type":"password"}}', $actual);
    }
}

class MockTransformer implements DataTransformerInterface
{
    public function setUserFormat()
    {
    }
    public function setInputFormat()
    {
    }
    public function transform($value)
    {
    }
    public function reverseTransform($value)
    {
    }
}
