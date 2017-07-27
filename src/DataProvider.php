<?php

declare(strict_types=1);

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
