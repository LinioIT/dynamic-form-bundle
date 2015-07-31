<?php

namespace Linio\DynamicFormBundle\Tests\Form\FormFactoryTest;

use Linio\DynamicFormBundle\Form\FormFactory;
use Linio\DynamicFormBundle\FormlyMapper\FormlyMapper;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Validator\Constraints\IsTrue;
use \Symfony\Component\Form\FormBuilder;
use \Symfony\Component\Form\FormFactory as SymfonyFormFactory;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

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
        $formFactoryMock = $this->prophesize(SymfonyFormFactory::class);
        $formBuilderMock = $this->prophesize(FormBuilder::class);

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

        $formFactoryMock->createNamedBuilder('foo', 'form', ['foo_form_data'], ['foo_form_options'])
            ->shouldBeCalled()
            ->willReturn($formBuilderMock->reveal());

        $formBuilderMock->create('field1', 'field1_type', ['field1_options'])
            ->shouldBeCalled()
            ->willReturn('field1_instance');

        $formBuilderMock->add('field1_instance')
            ->shouldBeCalled();

        $formBuilderMock->getForm()
            ->willReturn('foo_form');

        $formFactory = new FormFactory();
        $formFactory->setFormFactory($formFactoryMock->reveal());
        $formFactory->setConfiguration($formConfiguration);

        $actual = $formFactory->createForm('foo', ['foo_form_data'], ['foo_form_options']);

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsCreatingFormWithValidators()
    {
        $formFactoryMock = $this->prophesize(SymfonyFormFactory::class);
        $formBuilderMock = $this->prophesize(FormBuilder::class);

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

        $formFactoryMock->createNamedBuilder('foo', 'form', [], [])
            ->shouldBeCalled()
            ->willReturn($formBuilderMock->reveal());

        $formBuilderMock->create('field1', 'field1_type', $expectedFieldOptions)
            ->shouldBeCalled()
            ->willReturn('field1_instance');

        $formBuilderMock->add('field1_instance')
            ->shouldBeCalled();

        $formBuilderMock->getForm()
            ->willReturn('foo_form');

        $formFactory = new FormFactory();
        $formFactory->setFormFactory($formFactoryMock->reveal());
        $formFactory->setConfiguration($formConfiguration);

        $actual = $formFactory->createForm('foo');

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsCreatingFormWithTransformers()
    {
        $formFactoryMock = $this->prophesize(SymfonyFormFactory::class);
        $formBuilderMock = $this->prophesize(FormBuilder::class);
        $fieldOneMock = $this->prophesize(FormBuilder::class);

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

        $formFactoryMock->createNamedBuilder('foo', 'form', [], [])
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

        $formFactory = new FormFactory();
        $formFactory->setFormFactory($formFactoryMock->reveal());
        $formFactory->setConfiguration($formConfiguration);

        $actual = $formFactory->createForm('foo');

        $this->assertEquals('foo_form', $actual);
    }

    public function testIsGettingJsonConfiguration()
    {
        $formFactory = new FormFactory();
        $formFactory->setConfiguration([
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
        ]);

        $actual = $formFactory->getJsonConfiguration('foo');
        $expected = '{"email":{"enabled":true,"type":"email"},"password":{"enabled":false,"type":"password"}}';
        $this->assertEquals($expected, $actual);
    }

    public function testIsHandlingNullName()
    {
        $formFactory = new FormFactory();
        $formFactory->setConfiguration([
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
        ]);

        $actual = $formFactory->getJsonConfiguration(null);
        $expected = '{"foo":{"email":{"enabled":true,"type":"email"},"password":{"enabled":false,"type":"password"}}}';
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Linio\DynamicFormBundle\Exception\InexistentFormException
     */
    public function testIsHandlingNotExistenFormException()
    {
        $formFactory = new FormFactory();
        $formFactory->setConfiguration([
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
        ]);

        $formFactory->getJsonConfiguration('bar');
    }

    public function testIsGettingFormlyConfiguration()
    {
        $csrfTokenManagerMock = $this->prophesize(CsrfTokenManagerInterface::class);

        $csrfToken = new CsrfToken('new_user', 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw');

        $expected = [
            [
                'key' => 'name',
                'type' => 'input',
                'templateOptions' => [
                    'required' => true,
                    'label' => 'Nombre',
                    'type' => 'text',
                ],
            ],
            [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => 'bBKGCw4PKzaxanCnPPXy_aIZwNB5T6mccPKZl7XfWZw',
            ],
        ];

        $csrfTokenManagerMock->refreshToken('new_user')
            ->shouldBeCalled()
            ->willReturn($csrfToken);

        $formlyMapper = new FormlyMapper();
        $formlyMapper->setCsrfTokenManager($csrfTokenManagerMock->reveal());

        $formFactory = new FormFactory();
        $formFactory->setFormlyMapper($formlyMapper);

        $formFactory->setConfiguration([
            'new_user' => [
                'name' => [
                    'type' => 'text',
                    'options' => [
                        'required' => true,
                        'label' => 'Nombre',
                    ],
                ],
            ],
        ]);

        $actual = $formFactory->getFormlyConfiguration('new_user');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Linio\DynamicFormBundle\Exception\InexistentFormException
     */
    public function testIsThrowingExceptionWhenGettingJSONFromAnInexistentForm()
    {
        $formFactory = new FormFactory();
        $formFactory->setConfiguration(['foo' => []]);
        $formFactory->getFormlyConfiguration('bar');
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
