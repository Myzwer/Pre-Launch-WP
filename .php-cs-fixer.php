<?php

$finder = PhpCsFixer\Finder::create()
    // Only format root PHP files + includes folder
    ->in([
        __DIR__,
        __DIR__ . '/includes',
    ])
    ->name('*.php')
    // Do NOT recurse through everything under root (we only want root files + includes)
    ->depth('< 2')
    // Exclude common junk if it exists
    ->exclude([
        'vendor',
        'node_modules',
        'dist',
        'build',
        '.cache',
        '.git',
    ]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.cache/php-cs-fixer/.php-cs-fixer.cache')
    ->setFinder($finder)
    ->setRules([
        '@PSR12' => true,

        // Make diffs cleaner / consistency helpers
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => ['default' => 'single_space'],
        'blank_line_after_opening_tag' => true,
        'cast_spaces' => ['space' => 'single'],
        'concat_space' => ['spacing' => 'one'],
        'linebreak_after_opening_tag' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'no_extra_blank_lines' => true,
        'no_trailing_whitespace' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'whitespace_after_comma_in_array' => true,
    ]);
