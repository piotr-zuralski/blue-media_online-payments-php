<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->ignoreDotFiles(false)
    ->ignoreVCS(true);

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        'long_array_syntax',
        'ordered_use',
        'php_unit_construct',
        'php_unit_strict',
        'strict',
        'strict_param',
        'trailing_spaces',
        'encoding',
        'newline_after_open_tag',
        'phpdoc_order',
        'phpdoc_var_to_type',
    ])
    ->finder($finder)
    ->setUsingLinter(true)
    ->setUsingCache(false);
