<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\Exception\InvalidConfigurationException;
use Linio\DynamicFormBundle\Exception\NumberFormatException;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class BirthdayField extends FormlyField
{
    public const ORDER_ASC = 'asc';
    public const ORDER_DESC = 'desc';

    /**
     * {@inheritdoc}
     */
    public function getFieldType()
    {
        return 'birthday';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFieldTypeConfiguration(): void
    {
        $options = $this->fieldConfiguration['options'];

        $this->validateNumberFormatForSpecificRangeOfYearsArray($options);
        $this->validateMaxAgeAllowedIsLargerThanMinAgeAllowed($options);

        $this->formlyFieldConfiguration['templateOptions']['type'] = $this->getFieldType();

        $order = isset($options['order']) && (strtolower($options['order']) == (self::ORDER_ASC || self::ORDER_DESC))
        ? $options['order']
        : self::ORDER_DESC;

        unset($this->formlyFieldConfiguration['templateOptions']['order']);

        if (!isset($options['minAgeAllowed']) || !isset($options['maxAgeAllowed'])
            || !is_numeric($options['minAgeAllowed']) || !is_numeric($options['maxAgeAllowed'])
            || $options['minAgeAllowed'] < 0 || $options['maxAgeAllowed'] < 0) {
            $this->removeAgeAllowedFromTemplateOptions();

            return;
        }

        $yearsRange = range(date('Y') - $options['minAgeAllowed'], date('Y') - $options['maxAgeAllowed']);

        $this->formlyFieldConfiguration['templateOptions']['years'] = ($order == self::ORDER_ASC)
            ? array_reverse($yearsRange)
            : $yearsRange;

        $this->removeAgeAllowedFromTemplateOptions();
    }

    private function removeAgeAllowedFromTemplateOptions(): void
    {
        unset($this->formlyFieldConfiguration['templateOptions']['minAgeAllowed']);
        unset($this->formlyFieldConfiguration['templateOptions']['maxAgeAllowed']);
    }

    private function validateNumberFormatForSpecificRangeOfYearsArray(array $options): void
    {
        if (!isset($options['years'])) {
            return;
        }

        foreach ($options['years'] as $key => $year) {
            if (!is_numeric($year)) {
                throw new NumberFormatException(sprintf('The year "%s" does not have a valid number format.', $year));
            }

            $options['years'][$key] = (int) $year;
        }
    }

    private function validateMaxAgeAllowedIsLargerThanMinAgeAllowed(array $options): void
    {
        if (!isset($options['minAgeAllowed']) || !isset($options['maxAgeAllowed'])) {
            return;
        }

        if ((int) $options['minAgeAllowed'] > (int) $options['maxAgeAllowed']) {
            throw new InvalidConfigurationException(sprintf('The value of minAgeAllowed (%s) cannot be greater than maxAgeAllowed (%s).', $options['minAgeAllowed'], $options['maxAgeAllowed']));
        }
    }
}
