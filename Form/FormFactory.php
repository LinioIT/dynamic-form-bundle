<?php

namespace Linio\DynamicFormBundle\Form;

use Linio\DynamicFormBundle\DataProvider;
use Linio\DynamicFormBundle\HelpMessageProvider;
use Linio\DynamicFormBundle\Exception\NonExistentFormException;
use Linio\DynamicFormBundle\Exception\NotExistentDataProviderException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactory as SymfonyFormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Validation;

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
     * @var DataProvider[]
     */
    protected $dataProviders = [];

    /**
     * @var array
     */
    protected $eventSubscribers = [];

    /**
     * @var HelpMessageProvider[]
     */
    protected $helpMessageProviders = [];

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
     * @param string       $alias
     * @param DataProvider $dataProvider
     */
    public function addDataProvider($alias, DataProvider $dataProvider)
    {
        $this->dataProviders[$alias] = $dataProvider;
    }

    /**
     * @param string $alias
     * @param HelpMessageProvider $helpMessageProvider
     */
    public function addHelpMessageProvider($alias, HelpMessageProvider $helpMessageProvider)
    {
        $this->helpMessageProviders[$alias] = $helpMessageProvider;
    }

    /**
     * @param string                   $formName
     * @param EventSubscriberInterface $eventSubscriber
     */
    public function addEventSubscriber($formName, EventSubscriberInterface $eventSubscriber)
    {
        if (!isset($this->eventSubscribers[$formName])) {
            $this->eventSubscribers[$formName] = [];
        }

        $this->eventSubscribers[$formName][] = $eventSubscriber;
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
     * @throws NonExistentFormException
     */
    public function createBuilder($key, $data = [], $options = [], $name = null)
    {
        if (!isset($this->configuration[$key])) {
            throw new NonExistentFormException(sprintf('The form "%s" was not found.', $key));
        }

        $formBuilder = $this->formFactory->createNamedBuilder($name ?: $key, FormType::class, $data, $options);

        if (isset($this->eventSubscribers[$key])) {
            foreach ($this->eventSubscribers[$key] as $eventSubscriber) {
                $formBuilder->addEventSubscriber($eventSubscriber);
            }
        }

        foreach ($this->configuration[$key] as $key => $fieldConfiguration) {
            if (!$fieldConfiguration['enabled']) {
                continue;
            }

            $fieldOptions = isset($fieldConfiguration['options']) ? $fieldConfiguration['options'] : [];

            if (isset($fieldConfiguration['data_provider'])) {
                $fieldOptions['choices'] = $this->loadDataProvider($fieldConfiguration['data_provider'])->getData();
            }

            if (isset($fieldConfiguration['help_message_provider'])) {
                $fieldOptions['help'] = $this->loadHelpMessageProvider($fieldConfiguration['help_message_provider'])->getHelpMessage($fieldOptions['help']);
            }

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
     * This method generates a validator based on the configuration file.
     *
     * @param string $key The key of the Form in the form configuration
     * @param mixed $object Object which is the target of the validator
     *
     * @return ValidatorInterface
     *
     * @throws NonExistentFormException
     */
    public function createValidator($key, $object)
    {
        if (!isset($this->configuration[$key])) {
            throw new NonExistentFormException(sprintf('The form "%s" was not found.', $key));
        }

        $validator = Validation::createValidatorBuilder()->getValidator();
        $metadata = $validator->getMetadataFor(get_class($object));

        foreach ($this->configuration[$key] as $key => $fieldConfiguration) {
            if (!$fieldConfiguration['enabled']) {
                continue;
            }

            if (!isset($fieldConfiguration['validation'])) {
                continue;
            }

            foreach ($fieldConfiguration['validation'] as $validatorName => $options) {
                $metadata->addPropertyConstraint($key, new $validatorName($options));
            }
        }

        return $validator;
    }

    /**
     * @param string $alias
     *
     * @return DataProvider
     *
     * @throws NotExistentDataProviderException
     */
    public function loadDataProvider($alias)
    {
        if (!isset($this->dataProviders[$alias])) {
            throw new NotExistentDataProviderException();
        }

        return $this->dataProviders[$alias];
    }

    /**
     * @param string $alias
     *
     * @return HelpMessageProvider
     *
     * @throws NotExistentDataProviderException
     */
    public function loadHelpMessageProvider($alias)
    {
        if (!isset($this->helpMessageProviders[$alias])) {
            throw new NotExistentDataProviderException();
        }

        return $this->helpMessageProviders[$alias];
    }

    /**
     * @param string $name
     *
     * @return array
     *
     * @throws NonExistentFormException
     */
    public function getConfiguration($name = null)
    {
        if ($name === null) {
            return $this->configuration;
        }

        if (!$this->has($name)) {
            throw new NonExistentFormException();
        }

        return $this->configuration[$name];
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
