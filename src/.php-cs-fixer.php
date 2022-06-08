<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->exclude('Migrations')
    ->in(__DIR__ . '/');

return (new \PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PSR1'                                  => true,
            '@PSR2'                                  => true,
            '@PSR12'                                 => true,
            '@Symfony'                               => true,
            '@PHP71Migration:risky'                  => true,
            'concat_space'                           => ['spacing' => 'one'],
            'array_syntax'                           => ['syntax' => 'short'],
            'class_definition'                       => ['multi_line_extends_each_single_line' => true],
            'no_useless_else'                        => true,
            'ordered_imports'                        => ['sort_algorithm' => 'alpha'],
            'phpdoc_add_missing_param_annotation'    => ['only_untyped' => true],
            'list_syntax'                            => ['syntax' => 'short'],
            'linebreak_after_opening_tag'            => true,
            'void_return'                            => true,
            'phpdoc_summary'                         => false,
            'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
            'visibility_required'                    => [
                'elements' => ['property', 'method', 'const'],
            ],
        ]
    )
    ->setCacheFile(__DIR__ . '/runtime/php_cs.cache')
    ->setFinder($finder);