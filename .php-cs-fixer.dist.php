<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('test');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP71Migration'           => true,
        '@PHP71Migration:risky'     => true,
        '@PHPUnit84Migration:risky' => true,
        '@PhpCsFixer'               => true,
        '@PhpCsFixer:risky'         => true,
        'align_multiline_comment'   => ['comment_type' => 'phpdocs_like'],
        'binary_operator_spaces'    => [
            'default'   => 'align_single_space_minimal',
            'operators' => ['||' => null, '&&' => null, '|' => 'no_space'],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'const'        => 'only_if_meta',
                'property'     => 'only_if_meta',
                'method'       => 'one',
                'trait_import' => 'none',
            ]
        ],
        'class_definition' => [
            'single_item_single_line'             => true,
            'multi_line_extends_each_single_line' => true,
        ],
        'concat_space'                                     => ['spacing'  => 'one'],
        'control_structure_continuation_position'          => true,
        'date_time_create_from_format_call'                => true,
        'date_time_immutable'                              => true,
        'declare_parentheses'                              => true,
        'final_class'                                      => true,
        'final_public_method_for_abstract_class'           => true,
        'get_class_to_class_keyword'                       => true,
        'general_phpdoc_annotation_remove'                 => true,
        'global_namespace_import'                          => true,
        'mb_str_functions'                                 => true,
        'multiline_whitespace_before_semicolons'           => ['strategy' => 'no_multi_line'],
        'no_superfluous_phpdoc_tags'                       => ['allow_mixed' => true],
        'no_unset_on_property'                             => false,
        'nullable_type_declaration_for_default_null_value' => true,
        'operator_linebreak'                               => ['position' => 'beginning', 'only_booleans' => false],
        'ordered_class_elements'                           => ['sort_algorithm' => 'alpha'],
        'ordered_interfaces'                               => true,
        'ordered_imports'                                  => ['imports_order' => ['const', 'class', 'function']],
        'phpdoc_line_span'                                 => ['const' => 'single', 'property' => 'single'],
        'phpdoc_order_by_value'                            => ['annotations' => ['covers', 'depends', 'group', 'throws']],
        'phpdoc_tag_casing'                                => true,
        'phpdoc_types_order'                               => ['null_adjustment' => 'always_last'],
        'php_unit_test_class_requires_covers'              => false,
        'psr_autoloading'                                  => ['dir' => 'src'],
        'regular_callable_call'                            => true,
        'self_static_accessor'                             => true,
        'simplified_null_return'                           => true,
        'simplified_if_return'                             => true,
        'single_line_throw'                                => true,
        'static_lambda'                                    => true,
        'visibility_required'                              => ['elements' => ['property', 'method']], // PHP 7.0 compatibility
        'yoda_style'                                       => false,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
