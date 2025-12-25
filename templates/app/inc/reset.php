<?php


/**
 * Убрать из загрузки
 */
function plug_disable_emoji()
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

add_action('init', 'plug_disable_emoji', 1);

/**
 * Очистить в tinymce
 */
function plug_disable_tinymce_emoji($plugins)
{
    return array_diff($plugins, array('wpemoji'));
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
add_action('init', 'remove_wc_custom_action');
function remove_wc_custom_action()
{
    remove_action('wp_head', 'wc_gallery_noscript');
}

// Удалить vers от скриптов и стилей
function _remove_script_version($src)
{
    // Проверяем, есть ли знак вопроса в URL
    if (strpos($src, '?') !== false) {
        // Разбиваем строку по знаку вопроса
        $parts = explode('?', $src);
        // Проверяем, есть ли параметры после знака вопроса
        if (isset($parts[1])) {
            // Разбиваем параметры на массив
            parse_str($parts[1], $query);
            // Удаляем параметр 'ver', если он существует
            unset($query['ver']);
            // Собираем параметры обратно в строку
            $new_query = http_build_query($query);
            // Если параметры остались, добавляем их обратно
            return $parts[0] . (!empty($new_query) ? '?' . $new_query : '');
        }
    }
    // Если параметров нет, просто возвращаем исходный URL
    return $src;
}

add_filter('script_loader_src', '_remove_script_version', 15, 1);
add_filter('style_loader_src', '_remove_script_version', 15, 1);

// Удалить связи от мобильных приложений
add_filter('xmlrpc_enabled', '__return_false');

// Удалить Windows Live Writer
remove_action('wp_head', 'wlwmanifest_link');

// Disable Self Pingbacks
function no_self_ping(&$links)
{
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
}

add_action('pre_ping', 'no_self_ping');

// remove dashicons
function wpdocs_dequeue_dashicon()
{
    if (current_user_can('update_core')) {
        return;
    }
    wp_deregister_style('dashicons');
}

add_action('wp_enqueue_scripts', 'wpdocs_dequeue_dashicon');

/*
 *  Remove Google Maps API Call
 */
function disable_google_map_api($load_google_map_api)
{
    $load_google_map_api = false;
    return $load_google_map_api;
}

$plugins = get_option('active_plugins');
$required_plugin = 'auto-location-pro/auto-location.php';
if (in_array($required_plugin, $plugins)) {
    add_filter('avf_load_google_map_api', 'disable_google_map_api', 10, 1);
}
