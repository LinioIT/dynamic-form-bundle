<?php

namespace Linio\DynamicFormBundle\Form;

use Linio\DynamicFormBundle\Exception\NotExistentFormException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactory as SymfonyFormFactory;
use Symfony\Component\Form\FormInterface;

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
     * @param string $key     The key of the Form in the form configuration
     * @param array  $data
     * @param array  $options
     * @param string $name    An name for the form. If empty, the key will be used
     *
     * @return FormInterface
     */
    public function createForm($key, $data = [], $options = [], $name = null)
    {
        return $this->createBuilder($key, $data, $options, $name)->getForm();
    }

    /**
     * This method generates a form based on the configuration file.
     *
     * @param string $key     The key of the Form in the form configuration
     * @param array  $data
     * @param array  $options
     * @param string $name    An name for the form. If empty, the key will be used
     *
     * @return FormBuilderInterface
     *
     * @throws NotExistentFormException
     */
    public function createBuilder($key, $data = [], $options = [], $name = null)
    {
        if (!isset($this->configuration[$key])) {
            throw new NotExistentFormException(sprintf('The form "%s" was not found.', $key));
        }

        $formBuilder = $this->formFactory->createNamedBuilder($name ?: $key, 'form', $data, $options);

        foreach ($this->configuration[$key] as $key => $fieldConfiguration) {
            if (!$fieldConfiguration['enabled']) {
                continue;
            }

            $fieldOptions = isset($fieldConfiguration['options']) ? $fieldConfiguration['options'] : [];

            if (isset($fieldConfiguration['validation'])) {
                $constraints = [];

                foreach ($fieldConfiguration['validation'] as $validatorName => $options) {
                    $constraints[] = new $validatorName($options);
                }

                $fieldOptions['constraints'] = $constraints;
            }

            $field = $formBuilder->create($key, $fieldConfiguration['type'], $fieldOptions);

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

        return $formBuilder;
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws NotExistentFormException
     */
    public function getJsonConfiguration($name = null)
    {
        if ($name === null) {
            return json_encode($this->configuration);
        }

        if (!$this->has($name)) {
            throw new NotExistentFormException();
        }

        return json_encode($this->configuration[$name]);
    }

    /**
     * Checks if a given form exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->configuration[$name]);
    }
}
