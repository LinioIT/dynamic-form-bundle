<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper;

use Linio\DynamicFormBundle\Exception\FormlyMapperException;
use Linio\DynamicFormBundle\Exception\NonExistentFormException;
use Linio\DynamicFormBundle\Form\FormFactory;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField\FormlyFieldFactory;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class FormlyMapper
{
    /**
     * @var CsrfTokenManagerInterface
     */
    protected $csrfTokenManager;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var FormlyFieldFactory
     */
    protected $formlyFieldFactory;

    public function setCsrfTokenManager(CsrfTokenManagerInterface $csrfTokenManager): void
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function setFormFactory(FormFactory $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    public function setFormlyFieldFactory(FormlyFieldFactory $formlyFieldFactory): void
    {
        $this->formlyFieldFactory = $formlyFieldFactory;
    }

    /**
     * @param string $formName
     *
     * @throws FormlyMapperException
     *
     * @return array
     */
    public function map($formName = null)
    {
        $formlyConfiguration = [];

        try {
            $configuration = (array) $this->formFactory->getConfiguration($formName);
        } catch (NonExistentFormException $e) {
            throw new FormlyMapperException($e->getMessage());
        }

        if (!empty($configuration)) {
            foreach ($configuration as $fieldName => $fieldConfiguration) {
                $fieldConfiguration['name'] = $fieldName;

                $formlyField = $this->formlyFieldFactory->getFormlyField($fieldConfiguration['type']);
                $formlyField->setFieldConfiguration($fieldConfiguration);

                $formlyConfiguration[] = $formlyField->getFormlyFieldConfiguration();
            }
        }

        $formName = (!empty($formName)) ? $formName : 'form';

        $token = $this->csrfTokenManager->refreshToken($formName);

        $tokenFieldConfiguration = [
            'key' => '_token',
            'type' => 'hidden',
            'defaultValue' => $token->getValue(),
        ];

        $formlyConfiguration[] = $tokenFieldConfiguration;

        return $formlyConfiguration;
    }
}
