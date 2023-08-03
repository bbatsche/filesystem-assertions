<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP71Migration'           => true,
        '@PHP71Migration:risky'     => true,
        '@PHPUnit84Migration:risky' => true,
        '@PhpCsFixer'               => true,
        '@PhpCsFixer:risky'         => true,
        'binary_operator_spaces'    => [
            'default'   => 'align_single_space_minimal',
            'operators' => ['||' => 'single_space', '&&' => 'single_space', '|' => 'no_space'],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'const'        => 'only_if_meta',
                'method'       => 'one',
                'property'     => 'only_if_meta',
                'trait_import' => 'none',
            ],
        ],
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_item_single_line'             => true,
            'space_before_parenthesis'            => true,
        ],
        'concat_space'                           => ['spacing' => 'one'],
        'date_time_immutable'                    => true,
        'echo_tag_syntax'                        => ['format' => 'short'],
        'escape_implicit_backslashes'            => ['single_quoted' => true],
        'final_class'                            => true,
        'final_public_method_for_abstract_class' => true,
        'general_phpdoc_annotation_remove'       => [
            'annotations' => ['author', 'category', 'filesource', 'source'],
        ],
        'global_namespace_import'                          => true,
        'mb_str_functions'                                 => true,
        'multiline_whitespace_before_semicolons'           => ['strategy' => 'no_multi_line'],
        'native_constant_invocation'                       => true,
        'no_unset_on_property'                             => false,
        'nullable_type_declaration_for_default_null_value' => true,
        'operator_linebreak'                               => ['only_booleans' => false],
        'ordered_class_elements'                           => ['sort_algorithm' => 'alpha'],
        'ordered_interfaces'                               => true,
        'phpdoc_line_span'                                 => ['const' => 'single', 'property' => 'single'],
        'phpdoc_tag_casing'                                => true,
        'phpdoc_types_order'                               => ['null_adjustment' => 'always_last'],
        'php_unit_test_case_static_method_calls'           => ['call_type' => 'self'],
        'php_unit_test_class_requires_covers'              => false,
        'psr_autoloading'                                  => ['dir' => 'src'],
        'regular_callable_call'                            => true,
        'simplified_if_return'                             => true,
        'simplified_null_return'                           => true,
        'static_lambda'                                    => true,
        'trailing_comma_in_multiline'                      => ['elements' => ['arrays']],
        'yoda_style'                                       => ['equal' => false, 'identical' => false],
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
