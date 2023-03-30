<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$includedPatterns = [
    __DIR__ . '/src',
    __DIR__ . '/tests',
];

$rules = [
    '@Symfony' => true,
    // > PHPUnit
    'php_unit_method_casing' => ['case' => 'snake_case'],
    // > Strict
    'declare_strict_types' => false,
    // > Operator
    'not_operator_with_successor_space' => true,
    // > Cast Notation
    'cast_spaces' => ['space' => 'none'],
    // > Import
    'global_namespace_import' => [
        'import_classes' => true,
        'import_constants' => false,
        'import_functions' => false,
    ],
];

$finder = Finder::create()
    ->in($includedPatterns)
    ->name('*.php')
    ->notName('.*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = (new Config())->setRiskyAllowed(true)->setRules($rules)->setFinder($finder);

return $config;
