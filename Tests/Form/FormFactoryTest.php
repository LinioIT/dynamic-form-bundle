<?php

namespace Linio\DynamicFormBundle\Tests\Form\FormFactoryTest;

use Linio\DynamicFormBundle\Form\FormFactory;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Constraints\IsTrue;

class FormFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy
     */
    protected $formBuilderMock;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var ObjectProphecy
     */
    protected $formFactoryMock;
    /**
     * @expectedException \Linio\DynamicFormBundle\Exception\NonExistentFormException
     */
    public function testIsThrowingExceptionWhenCreatingAnInexistentForm()
    {
        $this->formFactory->setConfiguration(['foo' => []]);
        $this->formFactory->createForm('bar');
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

        $this->formFactoryMock->createNamedBuilder('foo', 'form', ['foo_form_data'], ['foo_form_options'])
            ->willReturn($this->formBuilderMock->reveal());

        $this->formBuilderMock->create('field1', 'field1_type', ['field1_options'])
            ->willReturn('field1_instance');

        $this->formBuilderMock->add('field1_instance')
            ->shouldBeCalled();

        $this->formBuilderMock->getForm()
            ->willReturn('foo_form');

        $this->formFactory->setFormFactory($this->formFactoryMock->reveal());
        $this->formFactory->setConfiguration($formConfiguration);

        $actual = $this->formFactory->createForm('foo', ['foo_form_data'], ['foo_form_options']);

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsCreatingFormWithValidators()
    {
        $formConfiguration = [
            'foo' => [
                'field1' => [
                    'enabled' => true,
                    'type' => 'field1_type',
                    'validation' => [
                        'Symfony\Component\Validator\Constraints\IsTrue' => [
                            'message' => 'The token is invalid.',
                        ],
                    ],
                ],
            ],
        ];

        $expectedFieldOptions = [
            'constraints' => [
                new IsTrue(['message' => 'The token is invalid.']),
            ],
        ];

        $this->formFactoryMock->createNamedBuilder('foo', 'form', [], [])
            ->willReturn($this->formBuilderMock->reveal());

        $this->formBuilderMock->create('field1', 'field1_type', $expectedFieldOptions)
            ->willReturn('field1_instance');

        $this->formBuilderMock->add('field1_instance')
            ->shouldBeCalled();

        $this->formBuilderMock->getForm()
            ->willReturn('foo_form');

        $this->formFactory->setFormFactory($this->formFactoryMock->reveal());
        $this->formFactory->setConfiguration($formConfiguration);

        $actual = $this->formFactory->createForm('foo');

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsCreatingFormWithTransformers()
    {
        $fieldOneMock = $this->prophesize('Symfony\Component\Form\FormBuilder');

        $formConfiguration = [
            'foo' => [
                'field1' => [
                    'enabled' => true,
                    'type' => 'field1_type',
                    'transformer' => [
                        'class' => 'Linio\DynamicFormBundle\Tests\Form\FormFactoryTest\MockTransformer',
                        'calls' => [
                            ['setUserFormat', ['d/m/Y']],
                            ['setInputFormat', ['Y-m-d']],
                        ],
                    ],
                ],
            ],
        ];

        $bornDateTransformer = new $formConfiguration['foo']['field1']['transformer']['class']();
        $bornDateTransformer->setUserFormat(['d/m/Y']);
        $bornDateTransformer->setInputFormat(['Y-m-d']);

        $expectedFieldOptions = [];

        $this->formFactoryMock->createNamedBuilder('foo', 'form', [], [])
            ->willReturn($this->formBuilderMock->reveal());

        $this->formBuilderMock->create('field1', 'field1_type', $expectedFieldOptions)
            ->willReturn($fieldOneMock->reveal());

        $fieldOneMock->addModelTransformer($bornDateTransformer)
            ->shouldBeCalled();

        $this->formBuilderMock->add($fieldOneMock->reveal())
            ->shouldBeCalledTimes(1);

        $this->formBuilderMock->getForm()
            ->willReturn('foo_form');

        $this->formFactory->setFormFactory($this->formFactoryMock->reveal());
        $this->formFactory->setConfiguration($formConfiguration);

        $actual = $this->formFactory->createForm('foo');

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsGettingConfiguration()
    {
        $configuration = [
            'foo' => [
                'email' => [
                    'enabled' => true,
                    'type' => 'email',
                ],
                'password' => [
                    'enabled' => false,
                    'type' => 'password',
                ],
            ],
        ];

        $this->formFactory->setConfiguration($configuration);

        $expected = $configuration['foo'];

        $actual = $this->formFactory->getConfiguration('foo');

        $this->assertEquals($expected, $actual);
    }

    public function testIsHandlingNullName()
    {
        $configuration = [
            'foo' => [
                'email' => [
                    'enabled' => true,
                    'type' => 'email',
                ],
                'password' => [
                    'enabled' => false,
                    'type' => 'password',
                ],
            ],
        ];

        $this->formFactory->setConfiguration($configuration);

        $actual = $this->formFactory->getConfiguration(null);

        $this->assertEquals($configuration, $actual);
    }

    /**
     * @expectedException \Linio\DynamicFormBundle\Exception\NonExistentFormException
     */
    public function testIsHandlingNotExistenFormException()
    {
        $configuration = [
            'foo' => [
                'email' => [
                    'enabled' => true,
                    'type' => 'email',
                ],
                'password' => [
                    'enabled' => false,
                    'type' => 'password',
                ],
            ],
        ];

        $this->formFactory->setConfiguration($configuration);

        $this->formFactory->getConfiguration('bar');
    }

    public function setup()
    {
        $this->formBuilderMock = $this->prophesize('Symfony\Component\Form\FormBuilder');
        $this->formFactoryMock = $this->prophesize('Symfony\Component\Form\FormFactory');

        $this->formFactory = new FormFactory();
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
