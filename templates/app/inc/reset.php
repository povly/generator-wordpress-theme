<?php

/**
 * Убрать из загрузки
 */
function {{FUNCTION}}_plug_disable_emoji(): void
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'plug_disable_tinymce_emoji');
}

add_action('init', '{{FUNCTION}}_plug_disable_emoji', 1);

/**
 * Очистить в tinymce
 */
function {{FUNCTION}}_plug_disable_tinymce_emoji($plugins): array
{
    return array_diff($plugins, ['wpemoji']);
}

// remove version from head
remove_action('wp_head', 'wp_generator');
// remove version from rss
add_filter('the_generator', '__return_empty_string');

// Remove REST API Links
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

remove_action('wp_head', 'wp_resource_hints', 2);
remove_action('wp_head', 'xforwc__add_meta_information_action', 99);
add_action('init', '{{FUNCTION}}_remove_wc_custom_action');
function {{FUNCTION}}_remove_wc_custom_action(): void
{
    remove_action('wp_head', 'wc_gallery_noscript');
}

// Удалить vers от скриптов и стилей
function {{FUNCTION}}_remove_script_version($src)
{
    // Проверяем, есть ли знак вопроса в URL
    if (str_contains((string) $src, '?')) {
        // Разбиваем строку по знаку вопроса
        $parts = explode('?', (string) $src);
        // Проверяем, есть ли параметры после знака вопроса
        if (isset($parts[1])) {
            // Разбиваем параметры на массив
            parse_str($parts[1], $query);
            // Удаляем параметр 'ver', если он существует
            unset($query['ver']);
            // Собираем параметры обратно в строку
            $new_query = http_build_query($query);

            // Если параметры остались, добавляем их обратно
            return $parts[0].($new_query === '' || $new_query === '0' ? '' : '?'.$new_query);
        }
    }

    // Если параметров нет, просто возвращаем исходный URL
    return $src;
}

add_filter('script_loader_src', '{{FUNCTION}}_remove_script_version', 15, 1);
add_filter('style_loader_src', '{{FUNCTION}}_remove_script_version', 15, 1);

// Удалить связи от мобильных приложений
add_filter('xmlrpc_enabled', '__return_false');

// Удалить Windows Live Writer
remove_action('wp_head', 'wlwmanifest_link');

// Disable Self Pingbacks
function {{FUNCTION}}_no_self_ping(array &$links): void
{
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (str_starts_with((string) $link, $home)) {
            unset($links[$l]);
        }
    }
}

add_action('pre_ping', '{{FUNCTION}}_no_self_ping');

// remove dashicons
function {{FUNCTION}}_wpdocs_dequeue_dashicon(): void
{
    if (current_user_can('update_core')) {
        return;
    }
    wp_deregister_style('dashicons');
}

add_action('wp_enqueue_scripts', '{{FUNCTION}}_wpdocs_dequeue_dashicon');

/*
 *  Remove Google Maps API Call
 */
function {{FUNCTION}}_disable_google_map_api($load_google_map_api): bool
{
    return false;
}

$plugins = get_option('active_plugins');
$required_plugin = 'auto-location-pro/auto-location.php';
if (in_array($required_plugin, $plugins)) {
    add_filter('avf_load_google_map_api', '{{FUNCTION}}_disable_google_map_api', 10, 1);
}
