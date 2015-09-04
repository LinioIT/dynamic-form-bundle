<?php

namespace Linio\DynamicFormBundle;


interface DataProvider
{
    /**
     * Retrieve data for collection fields.
     *
     * @return array
     */
    public function getData();
}