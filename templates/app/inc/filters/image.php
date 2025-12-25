<?php
/**
 * Дополнительная обработка HTML тега изображения
 */
add_filter('wp_get_attachment_image', function ($html, $attachment_id, $size, $icon, $attr) {
    // Проверяем наличие data-lazy в переданных атрибутах
    $lazy_loading = $attr['data-lazy'] ?? false;

    if ($lazy_loading && !is_admin()) {
        // SVG placeholder для ленивой загрузки
        $svg_placeholder = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxIiBoZWlnaHQ9IjEiPjwvc3ZnPg==';

        // Заменяем src на data-src
        $html = preg_replace('/\ssrc="([^"]*)"/', ' data-src="$1" src="' . $svg_placeholder . '"', $html);

        // Заменяем srcset на data-srcset
        $html = preg_replace('/\ssrcset="([^"]*)"/', ' data-srcset="$1" srcset="' . $svg_placeholder . '"', $html);

        // Заменяем sizes на data-sizes
        $html = preg_replace('/\ssizes="([^"]*)"/', ' data-sizes="$1" sizes=""', $html);

        // Убираем loading="lazy"
        $html = preg_replace('/\sloading="lazy"/', '', $html);

        // Добавляем класс lazy
        if (preg_match('/class="([^"]*)"/', $html)) {
            $html = preg_replace('/class="([^"]*)"/', 'class="$1 lazy"', $html);
        } else {
            $html = preg_replace('/<img/', '<img class="lazy"', $html);
        }
    }

    // Обрабатываем кастомные размеры
    if (isset($attr['data-width'])) {
        if (preg_match('/width="([^"]*)"/', $html)) {
            $html = preg_replace('/width="([^"]*)"/', 'width="' . esc_attr($attr['data-width']) . '"', $html);
        } else {
            $html = preg_replace('/<img/', '<img width="' . esc_attr($attr['data-width']) . '"', $html);
        }
    }

    if (isset($attr['data-height'])) {
        if (preg_match('/height="([^"]*)"/', $html)) {
            $html = preg_replace('/height="([^"]*)"/', 'height="' . esc_attr($attr['data-height']) . '"', $html);
        } else {
            $html = preg_replace('/<img/', '<img height="' . esc_attr($attr['data-height']) . '"', $html);
        }
    }

    // Убираем служебные атрибуты из HTML
    $html = preg_replace('/\sdata-lazy="[^"]*"/', '', $html);
    $html = preg_replace('/\sdata-width="[^"]*"/', '', $html);
    $html = preg_replace('/\sdata-height="[^"]*"/', '', $html);

    return $html;
}, 10, 5);


add_filter('wp_calculate_image_sizes', function ($sizes, $size, $image_src, $image_meta, $attachment_id) {

    $_sizes = '';

    $data_sizes = isset($image_meta['sizes']) ? $image_meta['sizes'] : [];

    if (is_array($data_sizes) && count($data_sizes) > 0) {
        foreach ($data_sizes as $_size) {
            $_sizes .= '(max-width:' . $_size['width'] . 'px) ' . $_size['width'] . 'px, ';
        }
    }

    $_sizes .= $image_meta['width'] . 'px';


    return $_sizes;
}, 50, 5);

// https://wordpress.org/support/topic/remove-sizesauto-in-wordpress-6-7/
add_filter('wp_img_tag_add_auto_sizes', '__return_false');
