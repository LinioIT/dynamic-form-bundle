<?php

namespace Linio\DynamicFormBundle\FormlyMapper;

/**
 * @codeCoverageIgnore
 */
trait FormlyAware
{
    /**
     * @var FormlyMapper
     */
    protected $formlyMapper;

    /**
     * @param FormlyMapper $formlyMapper
     */
    public function setFormlyMapper(FormlyMapper $formlyMapper)
    {
        $this->formlyMapper = $formlyMapper;
    }

    /**
     * @return FormlyMapper
     */
    public function getFormlyMapper()
    {
        return $this->formlyMapper;
    }
}
