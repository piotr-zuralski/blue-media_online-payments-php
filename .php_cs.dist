<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->ignoreDotFiles(false)
    ->exclude([
        '.git/',
        '.idea/',
    ]);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        'psr0' => true,

        // psr-1
        'encoding' => true,     // PHP code MUST use only UTF-8 without BOM (remove BOM)
        'full_opening_tag' => true,

        // psr-2
        'braces' => true,
        'elseif' => true,
        'single_blank_line_at_eof' => true,
        'no_spaces_after_function_name' => true,
        'function_declaration' => true,
        'indentation_type' => true,
        'blank_line_after_namespace' => true,
        'line_ending' => true,
        'lowercase_constants' => true,
        'lowercase_keywords' => true,
        'method_argument_space' => true,
        'single_import_per_statement' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_closing_tag' => true,
        'single_line_after_imports' => true,
        'no_trailing_whitespace' => true,
        'visibility_required' => true,

        // symfony
        'whitespace_after_comma_in_array' => true,
        'blank_line_after_opening_tag' => true,
        'no_empty_statement' => true,
        'simplified_null_return' => true,
        'function_typehint_space' => true,
        'include' => true,
        'no_alias_functions' => true,
        'trailing_comma_in_multiline_array' => true,
        'no_leading_namespace_whitespace' => true,
        'new_with_braces' => true,
        'no_blank_lines_after_phpdoc' => true,
        'phpdoc_inline_tag' => true,
        'phpdoc_no_access' => true,
        'phpdoc_align' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_scalar' => true,
        'phpdoc_summary' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'pre_increment' => true,
        'no_mixed_echo_print' => ['use' => 'echo'],
        'no_leading_import_slash' => true,
        'no_extra_consecutive_blank_lines' => true,
        'blank_line_before_return' => true,
        'no_short_bool_cast' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'single_blank_line_before_namespace' => true,
        'single_quote' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'cast_spaces' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,

        // contrib
        'concat_space' => ['spacing' => 'one'],
        'ereg_to_preg' => true,
        'linebreak_after_opening_tag' => true,
        'ordered_imports' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'no_short_echo_tag' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'long'],
        'no_php4_constructor' => true,
        'strict_comparison' => true,
    ])
    ->setFinder($finder)
    ->setUsingCache(false)
    ;