<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle;

interface HelpMessageProvider
{
    /**
     * @param string $key
     *
     * @return string
     */
    public function getHelpMessage($key);
}
