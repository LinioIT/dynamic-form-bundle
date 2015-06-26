<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

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

            default:
                $instance = new TextField();
                break;
        }

        return $instance;
    }
}
