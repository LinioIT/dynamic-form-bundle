<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

use Linio\DynamicFormBundle\FormlyMapper\FormlyFields\CheckboxField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyFields\DateField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyFields\TextAreaField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyFields\TextField;
use Linio\DynamicFormBundle\FormlyMapper\FormlyFields\NumberField;

class FormlyFieldFactory
{
    public static function create($type)
    {
        $instance = null;

        switch ($type) {

            case 'text':
                $instance = new TextField();
                break;

            case 'number':
                $instance = new NumberField();
                break;

            case 'textarea':
                $instance = new TextAreaField();
                break;

            case 'date':
                $instance = new DateField();
                break;

            case 'checkbox':
                $instance = new CheckboxField();
                break;

            default:
                $instance = new TextField();
                break;
        }

        return $instance;
    }
}
