<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\Form\FormFactoryTest;

use Linio\DynamicFormBundle\Exception\NonExistentFormException;
use Linio\DynamicFormBundle\Form\FormFactory;
use Linio\DynamicFormBundle\HelpMessageProvider;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory as SymfonyFormFactory;
use Symfony\Component\Validator\Constraints\IsTrue;

class FormFactoryTest extends TestCase
{
    use ProphecyTrait;

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

    public function testIsThrowingExceptionWhenCreatingAnInexistentForm(): void
    {
        $this->expectException(NonExistentFormException::class);

        $this->formFactory->setConfiguration(['foo' => []]);
        $this->formFactory->createForm('bar');
    }

    public function testIsCreatingASimpleForm(): void
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

        $this->formFactoryMock->createNamedBuilder('foo', FormType::class, ['foo_form_data'], ['foo_form_options'])
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

    public function testIsCreatingFormWithBirthdayFieldWithYearsAllowed(): void
    {
        $minAgeAllowed = 0;
        $maxAgeAllowed = 18;

        $formConfiguration = [
            'foo' => [
                'borndate' => [
                    'enabled' => true,
                    'type' => 'Symfony\Component\Form\Extension\Core\Type\BirthdayType',
                    'options' => [
                        'minAgeAllowed' => $minAgeAllowed,
                        'maxAgeAllowed' => $maxAgeAllowed,
                        'order' => 'desc',
                    ],
                ],
            ],
        ];

        $expectedFieldOptions = [
            'label' => 'borndate',
            'years' => range(date('Y') - $minAgeAllowed, date('Y') - $maxAgeAllowed),
        ];

        $this->formFactoryMock->createNamedBuilder('foo', FormType::class, ['foo_form_data'], ['foo_form_options'])
            ->willReturn($this->formBuilderMock->reveal());

        $this->formBuilderMock->create('borndate', BirthdayType::class, $expectedFieldOptions)
            ->willReturn('borndate_instance');

        $this->formBuilderMock->add('borndate_instance')
            ->shouldBeCalled();

        $this->formBuilderMock->getForm()
            ->willReturn('foo_form');

        $this->formFactory->setFormFactory($this->formFactoryMock->reveal());
        $this->formFactory->setConfiguration($formConfiguration);

        $actual = $this->formFactory->createForm('foo', ['foo_form_data'], ['foo_form_options']);

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsCreatingFormWithValidators(): void
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

        $this->formFactoryMock->createNamedBuilder('foo', FormType::class, [], [])
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

    public function testIsCreatingFormWithTransformers(): void
    {
        $fieldOneMock = $this->prophesize(FormBuilder::class);

        $formConfiguration = [
            'foo' => [
                'field1' => [
                    'enabled' => true,
                    'type' => 'field1_type',
                    'transformer' => [
                        'class' => MockTransformer::class,
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

        $this->formFactoryMock->createNamedBuilder('foo', FormType::class, [], [])
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

    public function testIsCreatingFormWithHelpMessages(): void
    {
        $formConfiguration = [
            'foo' => [
                'field1' => [
                    'enabled' => true,
                    'type' => 'field1_type',
                    'help_message_provider' => 'cache',
                    'options' => [
                        'help' => 'cms:message',
                    ],
                ],
            ],
        ];

        $helpMessageProviderMock = $this->prophesize(HelpMessageProvider::class);

        $helpMessageProviderMock->getHelpMessage('cms:message')
            ->shouldBeCalled()
            ->willReturn('message');

        $this->formFactoryMock->createNamedBuilder('foo', FormType::class, ['foo_form_data'], $formConfiguration)
            ->shouldBeCalled()
            ->willReturn($this->formBuilderMock->reveal());

        $this->formBuilderMock->create('field1', 'field1_type', ['help' => 'message'])
            ->shouldBeCalled()
            ->willReturn('field1_instance');

        $this->formBuilderMock->add('field1_instance')
            ->shouldBeCalled();

        $this->formBuilderMock->getForm()
            ->shouldBeCalled()
            ->willReturn('foo_form');

        $this->formFactory->setFormFactory($this->formFactoryMock->reveal());
        $this->formFactory->setConfiguration($formConfiguration);
        $this->formFactory->addHelpMessageProvider('cache', $helpMessageProviderMock->reveal());

        $actual = $this->formFactory->createForm('foo', ['foo_form_data'], $formConfiguration);

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsGettingConfiguration(): void
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

    public function testIsHandlingNullName(): void
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

    public function testIsHandlingNotExistenFormException(): void
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

        $this->expectException(NonExistentFormException::class);

        $this->formFactory->getConfiguration('bar');
    }

    public function testIsCreatingValidator(): void
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

        $this->formFactory->setConfiguration($formConfiguration);
        $validator = $this->formFactory->createValidator('foo', new MockValidatedClass());
        $this->assertEmpty($validator->validate(new MockValidatedClass()));
    }

    public function setup(): void
    {
        $this->formBuilderMock = $this->prophesize(FormBuilder::class);
        $this->formFactoryMock = $this->prophesize(SymfonyFormFactory::class);

        $this->formFactory = new FormFactory();
    }
}

class MockTransformer implements DataTransformerInterface
{
    public function setUserFormat(): void
    {
    }

    public function setInputFormat(): void
    {
    }

    public function transform($value): void
    {
    }

    public function reverseTransform($value): void
    {
    }
}

class MockValidatedClass
{
    public $field1 = true;
}
