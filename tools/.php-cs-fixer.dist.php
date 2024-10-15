<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__.'/../config',
        __DIR__.'/../migrations',
        __DIR__.'/../src',
        __DIR__.'/../tests',
    ])
    ->append([__FILE__])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR1' => true,
        '@PSR2' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'trailing_comma_in_multiline' => true,
        'declare_strict_types' => true,
        'phpdoc_separation' => false,
        'global_namespace_import' => [
            'import_constants' => null,
            'import_functions' => null,
            'import_classes' => null,
        ],
        'single_line_comment_spacing' => false,
        'no_unneeded_control_parentheses' => false,
        'blank_line_between_import_groups' => false,
        'class_attributes_separation' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
