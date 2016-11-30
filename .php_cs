<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->ignoreDotFiles(false)
    ->exclude([
        '.git/',
        '.idea/',
    ]);

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        'psr0',

        // psr-1
        'encoding',     // PHP code MUST use only UTF-8 without BOM (remove BOM)
        'short_tag',

        // psr-2
        'braces',
        'elseif',
        'eof_ending',
        'function_call_space',
        'function_declaration',
        'indentation',
        'line_after_namespace',
        'linefeed',
        'lowercase_constants',
        'lowercase_keywords',
        'method_argument_space',
        'multiple_use',
        'parenthesis',
        'php_closing_tag',
        'single_line_after_imports',
        'trailing_spaces',
        'visibility',

        // symfony
        'array_element_white_space_after_comma',
        'blankline_after_open_tag',
        'duplicate_semicolon',
        'empty_return',
        'function_typehint_space',
        'include',
        'join_function',
        'multiline_array_trailing_comma',
        'namespace_no_leading_whitespace',
        'new_with_braces',
        'no_empty_lines_after_phpdocs',
        'phpdoc_inline_tag',
        'phpdoc_no_access',
        'phpdoc_params',
        'phpdoc_scalar',
        'phpdoc_short_description',
        'phpdoc_trim',
        'phpdoc_types',
        'pre_increment',
        'print_to_echo',
        'remove_leading_slash_use',
        'remove_lines_between_uses',
        'return',
        'short_bool_cast',
        'single_array_no_trailing_comma',
        'single_blank_line_before_namespace',
        'single_quote',
        'spaces_before_semicolon',
        'spaces_cast',
        'standardize_not_equal',
        'ternary_spaces',
        'unused_use',
        'whitespacy_lines',

        // contrib
        'concat_with_spaces',
        'ereg_to_preg',
        'newline_after_open_tag',
        'ordered_use',
        'php_unit_construct',
        'php_unit_strict',
        'short_array_syntax',
        'short_echo_tag',
        'strict',
        'strict_param',
    ])
    ->finder($finder)
    ->setUsingLinter(true)
    ->setUsingCache(false);