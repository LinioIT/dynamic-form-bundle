<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class BirthdayField extends FormlyField
{
    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    /**
     * {@inheritdoc}
     */
    protected function getFieldType()
    {
        return 'birthday';
    }

    /**
     * {@inheritdoc}
     */
    protected function buildFieldTypeConfiguration(): void
    {
        $this->formlyFieldConfiguration['templateOptions']['type'] = $this->getFieldType();
        $options = $this->fieldConfiguration['options'];
        
        $order = isset($options['order']) && (strtolower($options['order']) == (self::ORDER_ASC || self::ORDER_DESC))
        ? $options['order']
        : self::ORDER_DESC;

        unset($this->formlyFieldConfiguration['templateOptions']['order']);

        if(!isset($options['minAgeAllowed']) || !isset($options['maxAgeAllowed'])
            || !is_numeric($options['minAgeAllowed']) || !is_numeric($options['maxAgeAllowed'])
            || $options['minAgeAllowed'] < 0  ||  $options['maxAgeAllowed'] < 0) {
            $this->cleanAgeAllowedInTemplateOptionsArray();
            return;
        }

        $minAgeAllowed = min($options['minAgeAllowed'], $options['maxAgeAllowed']);
        $maxAgeAllowed = max($options['minAgeAllowed'], $options['maxAgeAllowed']);

        $yearsRange = range(date('Y')-$minAgeAllowed, date('Y')-$maxAgeAllowed);

        $this->formlyFieldConfiguration['templateOptions']['years'] = ($order == self::ORDER_ASC)
            ? array_reverse($yearsRange)
            : $yearsRange;

        $this->cleanAgeAllowedInTemplateOptionsArray();
    }

    private function cleanAgeAllowedInTemplateOptionsArray(): void
    {
        unset($this->formlyFieldConfiguration['templateOptions']['minAgeAllowed']);
        unset($this->formlyFieldConfiguration['templateOptions']['maxAgeAllowed']);
    }
}
