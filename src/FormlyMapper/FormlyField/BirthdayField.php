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

        if(isset($this->fieldConfiguration['options']['minYear']) && isset($this->fieldConfiguration['options']['maxYear'])) {
            $minYear = $this->fieldConfiguration['options']['minYear'];
            $maxYear = $this->fieldConfiguration['options']['maxYear'];
            if(is_numeric($minYear) && ($minYear >= 0) && is_numeric($maxYear) && ($maxYear >= 0)) {
                if($minYear > $maxYear) {
                    $tmp = $minYear;
                    $minYear = $maxYear;
                    $maxYear = $tmp;
                }
                
                $yearsRange = range(date('Y')-$minYear, date('Y')-$maxYear);

                $this->formlyFieldConfiguration['templateOptions']['years'] = ($order == 'asc') ? array_reverse($yearsRange) : $yearsRange;
            }

            unset($this->formlyFieldConfiguration['templateOptions']['minYear']);
            unset($this->formlyFieldConfiguration['templateOptions']['maxYear']);
        }
    }
}
