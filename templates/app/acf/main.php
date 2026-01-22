<?php

/**
 * Автоматически находит все ACF-блоки по наличию block.json
 *
 * @return array Список путей к блокам относительно /app/acf/blocks/
 */
function {{FUNCTION}}_get_acf_blocks(): array
{
    $blocks_dir = {{CONSTANT}}_PATH.'/app/acf/blocks';
    $blocks = [];

    if (! is_dir($blocks_dir)) {
        return $blocks;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($blocks_dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if (basename((string) $file) === 'block.json') {
            $relative_path = str_replace($blocks_dir.DIRECTORY_SEPARATOR, '', dirname((string) $file));
            $blocks[] = str_replace(DIRECTORY_SEPARATOR, '/', $relative_path);
        }
    }

    return $blocks;
}

/**
 * Автоматически находит все ACF-блоки по наличию enqueue.php
 *
 * @return array Ассоциативный массив блоков вида:
 *               '{{THEME_NAME}}/main-first' => [
 *               'is_styles' => true,
 *               'is_script' => true,
 *               'style_deps' => ['{{THEME_NAME}}-embla'],
 *               'script_deps' => ['{{THEME_NAME}}-embla']
 *               ],
 */
function {{FUNCTION}}_get_acf_blocks_with_enqueue(): array
{
    $blocks_dir = {{CONSTANT}}_PATH.'/app/acf/blocks';
    $blocks = [];

    if (! is_dir($blocks_dir)) {
        return $blocks;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($blocks_dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if (basename((string) $file) === 'enqueue.php') {
            $block_dir = dirname((string) $file);
            $relative_path = str_replace($blocks_dir.DIRECTORY_SEPARATOR, '', $block_dir);
            // Преобразуем путь вида "main/first" в "{{TEXT_DOMAIN}}/main-first"
            $block_name = '{{TEXT_DOMAIN}}/'.implode('-', array_map(sanitize_title(...), explode(DIRECTORY_SEPARATOR, $relative_path)));

            // Безопасно подключаем enqueue.php и получаем данные
            $enqueue_data = [];
            $file_path = $block_dir.DIRECTORY_SEPARATOR.'enqueue.php';
            if (file_exists($file_path)) {
                // Используем include_once в изолированной области, чтобы не засорять глобальный scope
                $enqueue_data = (fn() => include $file_path)();
            }

            // Убеждаемся, что enqueue.php вернул массив, иначе пропускаем
            if (is_array($enqueue_data)) {
                $blocks[$block_name] = $enqueue_data;
            }
        }
    }

    return $blocks;
}

/**
 * Регистрация ACF блоков
 */
function {{FUNCTION}}_acf_register_blocks(): void
{
    $blocks = {{FUNCTION}}_get_acf_blocks();

    foreach ($blocks as $block) {
        $block_path = {{CONSTANT}}_PATH.'/app/acf/blocks/'.$block;
        if (file_exists($block_path.'/block.json')) {
            register_block_type($block_path);
        }
    }
}

/**
 * Подключение файлов полей для блоков
 */
function {{FUNCTION}}_acf_include_block_fields(): void
{
    $blocks = {{FUNCTION}}_get_acf_blocks();

    foreach ($blocks as $block) {
        $fields_file = {{CONSTANT}}_PATH.'/app/acf/blocks/'.$block.'/fields.php';
        if (file_exists($fields_file)) {
            require_once $fields_file;
        }
    }
}

// Регистрируем блоки на хуке 'init'
add_action('init', '{{FUNCTION}}_acf_register_blocks');

// Подключаем ACF-поля на хуке 'acf/init'
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
        if ($category['slug'] === '{{TEXT_DOMAIN}}') {
            $include = false;
        }
    }

    if ($include) {
        $categories = array_merge(
            $categories,
            [
                [
                    'slug' => '{{TEXT_DOMAIN}}',
                    'title' => '{{THEME_NAME}} Blocks',
                    'icon' => '<svg id="iconce.com" width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><linearGradient id="r5" gradientUnits="userSpaceOnUse" gradientTransform="rotate(45)" style="transform-origin:center center"><stop stop-color="#FC466B"/><stop offset="1" stop-color="#3F5EFB"/></linearGradient><radialGradient id="r6" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(256) rotate(90) scale(512)"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0"/></radialGradient></defs><rect id="r4" width="64" height="64" x="0" y="0" rx="16" fill="url(#r5)" stroke="#FFFFFF" stroke-width="0" stroke-opacity="1%" paint-order="stroke"/><text x="50%" y="50%" font-size="32" font-weight="600" fill="#FFFFFF" font-family="sans-serif" text-anchor="middle" dy="0.35em">P</text></svg>',
                ],
            ]
        );
    }

    return $categories;
}

add_filter('block_categories_all', '{{FUNCTION}}_acf_block_categories');

// add_filter('acf/settings/show_admin', '__return_false');

require_once {{CONSTANT}}_PATH.'/app/acf/render.php';
require_once {{CONSTANT}}_PATH.'/app/acf/options.php';
require_once {{CONSTANT}}_PATH.'/app/acf/themes.php';
require_once {{CONSTANT}}_PATH.'/app/acf/portfolio.php';
