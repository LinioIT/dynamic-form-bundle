<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

abstract class FormlyField implements FormlyFieldInterface
{
    /**
     * @var array
     */
    protected $fieldConfiguration;

    /**
     * @var array
     */
    protected $formlyFieldConfiguration;

    /**
     * @param array $fieldConfiguration
     */
    public function setFieldConfiguration(array $fieldConfiguration)
    {
        $this->fieldConfiguration = $fieldConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormlyFieldConfiguration()
    {
        $this->formlyFieldConfiguration = [];

        $this->formlyFieldConfiguration['key'] = $this->fieldConfiguration['name'];
        $this->formlyFieldConfiguration['type'] = 'input';

        if (isset($this->fieldConfiguration['options'])) {
            $templateOptions = $this->fieldConfiguration['options'];

            $templateOptions['label'] = ucfirst($this->fieldConfiguration['name']);
            if (isset($this->fieldConfiguration['options']['label'])) {
                $templateOptions['label'] = ucfirst($this->fieldConfiguration['options']['label']);
            }

            $this->formlyFieldConfiguration['templateOptions'] = $templateOptions;
        }

        if (isset($this->fieldConfiguration['validation'])) {
            $validation = $this->fieldConfiguration['validation'];

            $notBlankConstraintClass = 'Symfony\Component\Validator\Constraints\NotBlank';

            if (isset($validation[$notBlankConstraintClass])) {
                $constraint = $validation[$notBlankConstraintClass];
                if (isset($constraint['message'])) {
                    $this->formlyFieldConfiguration['validation']['messages'] = $constraint['message'];
                }
            }

            $regexConstraintClass = 'Symfony\Component\Validator\Constraints\Regex';

            if (isset($validation[$regexConstraintClass])) {
                $constraint = $validation[$regexConstraintClass];
                $this->formlyFieldConfiguration['templateOptions']['pattern'] = $constraint['pattern'];
                if (isset($constraint['message'])) {
                    $this->formlyFieldConfiguration['validation']['messages'] = $constraint['message'];
                }
            }
        }

        $this->formlyFieldConfiguration['templateOptions']['type'] = $this->getTemplateFieldType();
        $this->generateSpecificConfiguration();

        return $this->formlyFieldConfiguration;
    }
}
