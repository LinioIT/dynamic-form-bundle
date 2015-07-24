<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__ . '/Exception')
    ->in(__DIR__ . '/Form')
    ->in(__DIR__ . '/Tests')
    ->name('*.php')
    ;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(['concat_with_spaces', 'short_array_syntax', 'ordered_use', '-pre_increment'])
    ->finder($finder)
    ->setUsingCache(true);
