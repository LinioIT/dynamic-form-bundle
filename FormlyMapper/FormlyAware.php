<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

/**
 * @codeCoverageIgnore
 */
trait FormlyAware
{
    /**
     * @var formlyMapper
     */
    protected $formlyMapper;

    /**
     * [setFormlyMapper description].
     *
     * @param FormlyMapper $formlyMapper [description]
     */
    public function setFormlyMapper(FormlyMapper $formlyMapper)
    {
        $this->formlyMapper = $formlyMapper;
    }

    /**
     * [getFormlyMapper description].
     *
     * @return [type] [description]
     */
    public function getFormlyMapper()
    {
        return $this->formlyMapper;
    }
}
