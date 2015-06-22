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
        foreach ($configuration as $field => $config) {
            $fieldConfiguration = [];

            $fieldConfiguration['key'] = $field;
            $fieldConfiguration['type'] = 'input';

            if (isset($config['options'])) {
                $templateOptions = [];

                if (isset($config['options']['label'])) {
                    $templateOptions['label'] = $config['options']['label'];
                    $templateOptions['placeholder'] = $config['options']['label'];
                } else {
                    $templateOptions['label'] = ucfirst($field);
                    $templateOptions['placeholder'] = ucfirst($field);
                }

                foreach ($config['options'] as $option => $value) {
                    $templateOptions[$option] = $value;
                }

                $fieldConfiguration['templateOptions'] = ($templateOptions);
            }

            $formlyConfiguration[] = $fieldConfiguration;
        }

        $token = $this->csrfTokenManager->refreshToken($formName);

        return $formlyConfiguration;
    }
}
