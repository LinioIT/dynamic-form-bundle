<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class FormlyMapper
{
    /**
     * @var CsrfTokenManagerInterface
     */
    protected $csrfTokenManager;

    /**
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function setCsrfTokenManager(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @param array $configuration
     *
     * @return array
     */
    public function map(array $configuration, $formName)
    {
        foreach ($configuration as $fieldName => $fieldConfiguration) {
            $fieldConfiguration['name'] = $fieldName;

            $formlyField = FormlyFieldFactory::create($fieldConfiguration['type']);
            $formlyField->setFieldConfiguration($fieldConfiguration);
            $formlyField->generateCommonConfiguration();

            $formlyConfiguration[] = $formlyField->getFieldConfiguration();
        }

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
