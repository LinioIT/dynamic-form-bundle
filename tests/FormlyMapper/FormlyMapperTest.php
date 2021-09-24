<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper;

use Linio\DynamicFormBundle\Exception\FormlyMapperException;
use Linio\DynamicFormBundle\Exception\NonExistentFormException;
use Linio\DynamicFormBundle\Form\FormFactory;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField\FormlyFieldFactory;
use Linio\DynamicFormBundle\FormlyMapper\FormlyMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Security\Csrf\CsrfToken;

class FormlyMapperTest extends TestCase
{
    /**
     * @var CsrfToken
     */
    protected $csrfToken;

    /**
     * @var ObjectProphecy
     */
    protected $csrfTokenManagerMock;

    /**
     * @var ObjectProphecy
     */
    protected $formFactoryMock;

    /**
     * @var ObjectProphecy
     */
    protected $formlyFieldMock;

    /**
     * @var ObjectProphecy
     */
    protected $formlyFieldFactoryMock;

    /**
     * @var FormlyMapper
     */
    protected $formlyMapper;

    public function testIsMappingCorrectly(): void
    {
        $formName = 'foo';
        $formType = 'number';

        $configuration = [
            'width' => [
                'type' => 'number',
                'options' => [
                    'required' => true,
                    'label' => 'Width',
                ],
            ],
        ];

        $this->formFactoryMock->getConfiguration($formName)
            ->willReturn($configuration);

        $this->formlyFieldFactoryMock->getFormlyField($formType)
            ->willReturn($this->formlyFieldMock->reveal());

        $fieldConfiguration = [
            'name' => 'width',
            'type' => 'number',
            'options' => [
                'required' => true,
                'label' => 'Width',
            ],
        ];

        $this->formlyFieldMock->setFieldConfiguration($fieldConfiguration)
            ->shouldBeCalled();

        $formlyConfiguration = [
            [
                'key' => 'width',
                'type' => 'input',
                'templateOptions' => [
                    'type' => 'number',
                    'label' => 'Width',
                    'required' => true,
                ],
            ],
        ];

        $this->formlyFieldMock->getFormlyFieldConfiguration()
            ->willReturn($formlyConfiguration);

        $this->csrfTokenManagerMock->refreshToken($formName)
            ->willReturn($this->csrfToken);

        $this->formlyMapper->setFormFactory($this->formFactoryMock->reveal());
        $this->formlyMapper->setFormlyFieldFactory($this->formlyFieldFactoryMock->reveal());
        $this->formlyMapper->setCsrfTokenManager($this->csrfTokenManagerMock->reveal());

        $expected = [
            $formlyConfiguration,
            [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => 'bar',
            ],
        ];

        $actual = $this->formlyMapper->map($formName);

        $this->assertEquals($expected, $actual);
    }

    public function testIsThrowingNonExistentFormException(): void
    {
        $this->expectException(FormlyMapperException::class);

        $formName = 'foo';

        $this->formFactoryMock->getConfiguration($formName)
            ->willThrow(NonExistentFormException::class);

        $this->formlyMapper->setFormFactory($this->formFactoryMock->reveal());

        $this->formlyMapper->map($formName);
    }

    public function setup(): void
    {
        $this->csrfToken = new CsrfToken('foo', 'bar');
        $this->csrfTokenManagerMock = $this->prophesize('Symfony\Component\Security\Csrf\CsrfTokenManagerInterface');
        $this->formFactoryMock = $this->prophesize(FormFactory::class);
        $this->formlyFieldFactoryMock = $this->prophesize(FormlyFieldFactory::class);
        $this->formlyFieldMock = $this->prophesize(FormlyField::class);

        $this->formlyMapper = new FormlyMapper();
    }
}
