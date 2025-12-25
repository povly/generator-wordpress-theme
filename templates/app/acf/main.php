<?php
/**
 * Массив всех ACF блоков
 *
 * @return array Список блоков для регистрации
 */
function {{FUNCTION}}_get_acf_blocks() {
    return [
        'main/first',
    ];
}

/**
 * Регистрация ACF блоков
 */
function {{FUNCTION}}_acf_register_blocks() {
    $blocks = {{FUNCTION}}_get_acf_blocks();


    foreach ($blocks as $block) {
        $block_path = {{CONSTANT}}_PATH . '/app/acf/blocks/' . $block;

        if (file_exists($block_path . '/block.json')) {
            register_block_type($block_path);
        }
    }
}

/**
 * Подключение файлов полей для блоков
 */
function {{FUNCTION}}_acf_include_block_fields() {
    $blocks = {{FUNCTION}}_get_acf_blocks();

    foreach ($blocks as $block) {
        $fields_file = {{CONSTANT}}_PATH . '/app/acf/blocks/' . $block . '/fields.php';
        if (file_exists($fields_file)) {
            require_once $fields_file;
        }
    }
}

// Регистрируем блоки
add_action('init', '{{FUNCTION}}_acf_register_blocks');

// Подключаем поля блоков
add_action('acf/init', '{{FUNCTION}}_acf_include_block_fields');


/**
 * Block categories
 *
 * @since 1.0.0
 */
function {{FUNCTION}}_acf_block_categories($categories)
{

    $include = true;
    foreach ($categories as $category) {
        if ('{{TEXT_DOMAIN}}' === $category['slug']) {
            $include = false;
        }
    }

    if ($include) {
        $categories = array_merge(
            $categories,
            [
                [
                    'slug' => '{{TEXT_DOMAIN}}',
                    'title' => 'American Beauty Group Blocks',
                    'icon' => '<svg id="iconce.com" width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><linearGradient id="r5" gradientUnits="userSpaceOnUse" gradientTransform="rotate(45)" style="transform-origin:center center"><stop stop-color="#FC466B"/><stop offset="1" stop-color="#3F5EFB"/></linearGradient><radialGradient id="r6" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(256) rotate(90) scale(512)"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0"/></radialGradient></defs><rect id="r4" width="64" height="64" x="0" y="0" rx="16" fill="url(#r5)" stroke="#FFFFFF" stroke-width="0" stroke-opacity="1%" paint-order="stroke"/><text x="50%" y="50%" font-size="32" font-weight="600" fill="#FFFFFF" font-family="sans-serif" text-anchor="middle" dy="0.35em">P</text></svg>',
                ]
            ]
        );
    }

    return $categories;
}

add_filter('block_categories_all', '{{FUNCTION}}_acf_block_categories');


// add_filter('acf/settings/show_admin', '__return_false');

require_once {{CONSTANT}}_PATH . '/app/acf/options.php';
require_once {{CONSTANT}}_PATH . '/app/acf/themes.php';