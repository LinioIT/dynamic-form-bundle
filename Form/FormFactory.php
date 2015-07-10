<?php

namespace Linio\DynamicFormBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactory as SymfonyFormFactory;
use Linio\DynamicFormBundle\Exception\NotExistentFormException;
use Symfony\Component\Form\FormInterface;
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
     * @param $name
     * @param array $data
     * @param array $options
     *
     * @return FormInterface
     */
    public function createForm($name, $data = [], $options = [])
    {
        return $this->createBuilder($name, $data, $options)->getForm();
    }

    /**
     * This method genetates a form based on the configuration file.
     *
*@param string $name The name of the Form
     * @param array $data
     * @param array $options
     *
     * @return FormBuilderInterface
     * @throws NotExistentFormException
     */
    public function createBuilder($name, $data = [], $options = [])
    {
        if (!isset($this->configuration[$name])) {
            throw new NotExistentFormException(sprintf('The form "%s" was not found.', $name));
        }

        $formBuilder = $this->formFactory->createNamedBuilder($name, 'form', $data, $options);


        foreach ($this->configuration[$name] as $name => $fieldConfiguration) {
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

        return $formBuilder;
    }
    
    /**
     * @return string
     * @throws NotExistentFormException
     */
    public function getJsonConfiguration($name)
    {
        if (!isset($this->configuration[$name])) {
            throw new NotExistentFormException();
        }

        return json_encode($this->configuration[$name]);
    }
}
