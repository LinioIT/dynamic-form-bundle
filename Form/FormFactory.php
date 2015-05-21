<?php

namespace Linio\DynamicFormBundle\Form;

use Symfony\Component\Form\FormFactory as SymfonyFormFactory;
use Linio\DynamicFormBundle\Exception\InexistentFormException;
use Symfony\Component\Validator\Constraints as Assert;

class FormFactory
{
    /**
     * @var SymfonyFormFactory
     */
    protected $formFactory;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @param SymfonyFormFactory $formFactory
     */
    public function setFormFactory(SymfonyFormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }


    /**
     * This method genetates a form based on the configuration file.
     * @param string $name The name of the Form
     * @param array $data
     * @param array $options
     * @return \Symfony\Component\Form\Form
     * @throws InexistentFormException
     */
    public function createForm($name, $data = [], $options = [])
    {
        if (!isset($this->configuration[$name])) {
            throw new InexistentFormException();
        }

        $formBuilder = $this->formFactory->createBuilder('form', $data, $options);


        foreach ($this->configuration[$name] as $name => $fieldConfiguration) {
            if (!$fieldConfiguration['enabled']) {
                continue;
            }

            $fieldOptions = isset($fieldConfiguration['options']) ? $fieldConfiguration['options'] : [];

            if (isset($fieldConfiguration['validators'])) {
                $constraints = [];

                foreach ($fieldConfiguration['validators'] as $validatorName => $options) {
                    $constraints[] = new $validatorName($options);
                }

                $fieldOptions['constraints'] = $constraints;
            }

            $field = $formBuilder->create($name, $fieldConfiguration['type'], $fieldOptions);


            if (isset($fieldConfiguration['transformer'])) {
                $transformerConfiguration = $fieldConfiguration['transformer'];
                $transformer = new $transformerConfiguration['class']();

                if (isset($transformerConfiguration['calls'])) {
                    foreach ($transformerConfiguration['calls'] as $call) {
                        call_user_func([$transformer, $call[0]], $call[1]);
                    }
                }

                $field->addModelTransformer($transformer);
            }

            $formBuilder->add($field);
        }

        return $formBuilder->getForm();
    }

    /**
     * @return string
     * @throws InexistentFormException
     */
    public function getJsonConfiguration()
    {
        $configuration = [];

        foreach ($this->configuration as $formName => $fieldConfiguration) {
            $fields = [];

            foreach ($fieldConfiguration as $field => $options) {
                if (!$options['enabled']) {
                    continue;
                }

                $fields[$field] = $options;
            }

            $configuration[$formName] = $fields;
        }

        return json_encode($configuration);
    }
}
