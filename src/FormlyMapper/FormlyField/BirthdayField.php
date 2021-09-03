<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField;

class BirthdayField extends FormlyField
{
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

        $order = 'desc';
        if(isset($this->fieldConfiguration['options']['order'])) {
            $tmpOrder = strtolower($this->fieldConfiguration['options']['order']);
            if($tmpOrder == 'asc' || $tmpOrder == 'desc') {
                $order = $tmpOrder;
            }
            unset($this->formlyFieldConfiguration['templateOptions']['order']);
        }

        if(isset($this->fieldConfiguration['options']['minAgeAllowed']) && isset($this->fieldConfiguration['options']['maxAgeAllowed'])) {
            $minAgeAllowed = $this->fieldConfiguration['options']['minAgeAllowed'];
            $maxAgeAllowed = $this->fieldConfiguration['options']['maxAgeAllowed'];
            if(is_numeric($minAgeAllowed) && ($minAgeAllowed >= 0) && is_numeric($maxAgeAllowed) && ($maxAgeAllowed >= 0)) {
                if($minAgeAllowed > $maxAgeAllowed) {
                    $tmp = $minAgeAllowed;
                    $minAgeAllowed = $maxAgeAllowed;
                    $maxAgeAllowed = $tmp;
                }
                
                $yearsRange = range(date('Y')-$minAgeAllowed, date('Y')-$maxAgeAllowed);

                $this->formlyFieldConfiguration['templateOptions']['years'] = ($order == 'asc') ? array_reverse($yearsRange) : $yearsRange;
            }

            unset($this->formlyFieldConfiguration['templateOptions']['minAgeAllowed']);
            unset($this->formlyFieldConfiguration['templateOptions']['maxAgeAllowed']);
        }
    }
}
