<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

use Linio\DynamicFormBundle\Exception\NonExistentFormException;
use Linio\DynamicFormBundle\Exception\FormlyMapperException;
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

    /**
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function setCsrfTokenManager(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @param FormFactory $formFactory
     */
    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param FormlyFieldFactory $formlyFieldFactory
     */
    public function setFormlyFieldFactory(FormlyFieldFactory $formlyFieldFactory)
    {
        $this->formlyFieldFactory = $formlyFieldFactory;
    }

    /**
     * @param string $formName
     *
     * @return array
     * @throws FormlyMapperException
     */
    public function map($formName = null)
    {
        try {
            $configuration = (array) $this->formFactory->getJsonConfiguration($formName);

            foreach ($configuration as $fieldName => $fieldConfiguration) {
                $fieldConfiguration['name'] = $fieldName;

                $formlyField = $this->formlyFieldFactory->getFormlyField($fieldConfiguration['type']);
                $formlyField->setFieldConfiguration($fieldConfiguration);

                $formlyConfiguration[] = $formlyField->getFormlyFieldConfiguration();
            }

            $formName = (!empty($formName)) ? $formName : 'form';

            $token = $this->csrfTokenManager->refreshToken($formName);

            $tokenFieldConfiguration = [
                'key' => '_token',
                'type' => 'hidden',
                'defaultValue' => $token->getValue(),
            ];

            $formlyConfiguration[] = $tokenFieldConfiguration;

        } catch(NonExistentFormException $e) {
            throw new FormlyMapperException($e->getMessage());
        }

        return $formlyConfiguration;
    }
}
