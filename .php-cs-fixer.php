<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(false)
    ->setRules([
        // Basic PSR-12 rules
        '@PSR12' => true,
        
        // Array syntax
        'array_syntax' => ['syntax' => 'short'],
        
        // Import related
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        
        // Basic formatting
        'binary_operator_spaces' => true,
        
        // PHP DocBlocks
        'phpdoc_scalar' => true,
        'phpdoc_var_without_name' => true,
    ])
    ->setFinder($finder);
