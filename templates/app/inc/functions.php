<?php

use Illuminate\Support\Collection;

/**
 * Function to generate a responsive <picture> element with lazy loading support for WordPress and Vite.
 * Now includes checks for file existence for the base image and each format.
 *
 * @param array $args Configuration array with the following keys:
 * - 'src': string, the base image source (e.g., 'resources/images/main/first/bg.jpg').
 * - 'formats': array of strings (e.g., ['avif', 'webp']) for additional formats.
 * - 'alt': string, alt text for the image.
 * - 'lazy': bool, whether to use lazy loading (default: false).
 * - 'classes': string or array, additional CSS classes (default: '').
 * - 'width': int, image width (default: null).
 * - 'height': int, image height (default: null).
 * - 'attributes': array, additional attributes for the <img> tag (default: []).
 *
 * @return string HTML string for the <picture> element or empty string if base file doesn't exist.
 */
function {{FUNCTION}}_get_static_picture($args = []) {
    $defaults = [
        'src' => '',
        'formats' => ['avif', 'webp'],
        'alt' => '',
        'lazy' => false,
        'classes' => '',
        'width' => null,
        'height' => null,
        'attributes' => [],
    ];
    $args = array_merge($defaults, $args);

    $src_relative = $args['src'];
    $src_full_url = {{CONSTANT}}_URI . '/' . $src_relative;
    $src_local_path = {{CONSTANT}}_PATH . '/' . $src_relative; // Local path for file existence check

    // If base file doesn't exist, return nothing
    if (!file_exists($src_local_path)) {
        return '';
    }

    $formats = $args['formats'];
    $alt = $args['alt'];
    $lazy = $args['lazy'];
    $classes = $args['classes'];
    $width = $args['width'];
    $height = $args['height'];
    $attributes = $args['attributes'];

    // Placeholder SVG for lazy loading
    $placeholder = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxIiBoZWlnaHQ9IjEiPjwvc3ZnPg==';

    // Helper function to get image extension from src
    $get_extension = function($path) {
        return pathinfo($path, PATHINFO_EXTENSION);
    };

    // Helper function to replace extension
    $replace_extension = function($path, $new_ext) {
        return preg_replace('/\.[^.]+$/', ".$new_ext", $path);
    };

    $original_ext = $get_extension($src_relative);
    $html = '<picture>';

    // Add sources for each format only if the file exists
    foreach ($formats as $format) {
        $format_src_relative = $replace_extension($src_relative, $format);
        $format_src_local = get_template_directory() . '/' . $format_src_relative;
        if (file_exists($format_src_local)) {
            $format_src_full_url = {{CONSTANT}}_URI . '/' . $format_src_relative;
            $html .= '<source type="image/' . $format . '"';
            if ($lazy) {
                $html .= ' srcset="' . $placeholder . '" data-srcset="' . $format_src_full_url . '"';
            } else {
                $html .= ' srcset="' . $format_src_full_url . '"';
            }
            $html .= '>';
        }
    }

    // Add the default img tag
    $img_attrs = [];
    if ($width !== null) {
        $img_attrs[] = 'width="' . esc_attr($width) . '"';
    }
    if ($height !== null) {
        $img_attrs[] = 'height="' . esc_attr($height) . '"';
    }
    if ($lazy) {
        $img_attrs[] = 'src="' . $placeholder . '"';
        $img_attrs[] = 'data-src="' . $src_full_url . '"';
        $img_attrs[] = 'loading="lazy"';
        $classes = is_array($classes) ? array_merge($classes, ['lazy']) : $classes . ' lazy';
    } else {
        $img_attrs[] = 'src="' . $src_full_url . '"';
    }
    if (!empty($alt)) {
        $img_attrs[] = 'alt="' . esc_attr($alt) . '"';
    }
    if (!empty($classes)) {
        $class_str = is_array($classes) ? implode(' ', $classes) : $classes;
        $img_attrs[] = 'class="' . esc_attr($class_str) . '"';
    }
    // Add any additional attributes
    foreach ($attributes as $key => $value) {
        $img_attrs[] = esc_attr($key) . '="' . esc_attr($value) . '"';
    }
    $html .= '<img ' . implode(' ', $img_attrs) . '>';

    $html .= '</picture>';
    return $html;
}

if (!function_exists('{{FUNCTION}}_get_acf_repeater')) {
    function {{FUNCTION}}_get_acf_repeater(array $acf_data, string $field_name, array $sub_fields = []): Collection
    {
        $repeater_name = $field_name . '_'; // Префикс, как 'repeater_items_'
        $repeater_count = $acf_data[$field_name] ?? 0;

        $items = collect();

        for ($i = 0; $i < $repeater_count; $i++) {
            $item = [];

            // Если sub_fields не указаны, берём все возможные ключи динамически
            if (empty($sub_fields)) {
                // Автоматически собираем все подполя для этого индекса
                foreach ($acf_data as $key => $value) {
                    if (strpos($key, $repeater_name . $i . '_') === 0) {
                        $sub_key = substr($key, strlen($repeater_name . $i . '_'));
                        $item[$sub_key] = $value;
                    }
                }
            } else {
                // Или берём только указанные подполя
                foreach ($sub_fields as $sub_field) {
                    $item[$sub_field] = $acf_data["{$repeater_name}{$i}_{$sub_field}"] ?? null;
                }
            }

            // Фильтруем пустые элементы (опционально)
            if (count(array_filter($item)) > 0) {
                $items->push($item);
            }
        }

        return $items;
    }
}

function my_admin_head_custom_styles() {
    echo '<style>
        html :where(.wp-block) {
            margin-bottom: 28px;
            max-width: 100%;
        }
    </style>';
}
add_action('admin_head', 'my_admin_head_custom_styles');


function abg_wpml_get_langs_titles(){
    $langs = get_field('all_translations', 'option');

    if(empty($langs)) {
        return [
            'ru' => 'Ру',
            'en' => 'En'
        ];
    }

    return array_column($langs, 'value', 'key');
}


/**
 * Получает значение поля в зависимости от контекста (админка или фронтенд).
 *
 * @param string $field Название поля.
 * @param array $data Массив данных для фронтенда.
 * @return mixed Значение поля.
 */
function get_acf_block_field_value(string $field, array $data = []) {
    return is_admin() ? get_field($field) : ($data[$field] ?? '');
}

/**
 * Generates array of pagination links.
 *
 * @author Kama (wp-kama.com)
 * @varsion 2.5
 *
 * @param array $args {
 *
 *     @type int    $total        Maximum allowable pagination page.
 *     @type int    $current      Current page number.
 *     @type string $first_url    URL to first page. Default: '' - taken automaticcaly from $url_base.
 *     @type int    $mid_size     Number of links before/after current: 1 ... 1 2 [3] 4 5 ... 99. Default: 2.
 *     @type int    $end_size     Number of links at the edges: 1 2 ... 3 4 [5] 6 7 ... 98 99. Default: 1.
 *     @type bool   $show_all     true - Show all links. Default: false.
 *     @type string $a_text_patt  `%s` will be replaced with number of pagination page. Default: `'%s'`.
 *     @type bool   $is_prev_next Whether to show prev/next links. « Previou 1 2 [3] 4 ... 99 Next ». Default: false.
 *     @type string $prev_text    Default: `« Previous`.
 *     @type string $next_text    Default: `Next »`.
 * }
 *
 * @return array
 */
function kama_paginate_links_data( array $args ): array {
    global $wp_query;

    $args += [
        'total'        => 1,
        'current'      => 0,
        'first_url'    => '',
        'mid_size'     => 2,
        'end_size'     => 1,
        'show_all'     => false,
        'a_text_patt'  => '%s',
        'is_prev_next' => false,
        'prev_text'    => '« Previous',
        'next_text'    => 'Next »',
    ];

    $rg = (object) $args;

    $total_pages = max( 1, (int) ( $rg->total ?: $wp_query->max_num_pages ) );

    if ( $total_pages === 1 ) {
        return [];
    }

    // Normalize parameters
    $rg->total = $total_pages;
    $rg->current = max( 1, abs( $rg->current ?: get_query_var( 'paged', 1 ) ) );

    $rg->url_base = isset($rg->url_base) ?: str_replace( PHP_INT_MAX, '{pagenum}', get_pagenum_link( PHP_INT_MAX ) );
    $rg->url_base = wp_normalize_path( $rg->url_base );

    if ( ! $rg->first_url ) {
        $rg->first_url = preg_replace(
            '~/paged?/{pagenum}/?|[?]paged?={pagenum}|/{pagenum}/?~',
            '',
            $rg->url_base
        );
        $rg->first_url = user_trailingslashit( $rg->first_url );
    }

    // Build page numbers
    if ( $rg->show_all ) {
        $active_nums = range( 1, $rg->total );
    } else {
        $start_nums = $rg->end_size > 1 ? range( 1, $rg->end_size ) : [ 1 ];
        $end_nums   = $rg->end_size > 1 ? range( $rg->total - ( $rg->end_size - 1 ), $rg->total ) : [ $rg->total ];

        $from = $rg->current - $rg->mid_size;
        $to   = $rg->current + $rg->mid_size;

        if ( $from < 1 ) {
            $to = min( $rg->total, $to + ( 1 - $from ) );
            $from = 1;
        }
        if ( $to > $rg->total ) {
            $from = max( 1, $from - ( $to - $rg->total ) );
            $to = $rg->total;
        }

        $active_nums = array_merge( $start_nums, range( $from, $to ), $end_nums );
        $active_nums = array_unique( $active_nums );
        sort( $active_nums );
    }

    if ( count( $active_nums ) <= 1 ) {
        return [];
    }

    // Closure to generate item data
    $item_data = static function ( $num ) use ( $rg ) {
        $data = [
            'is_current'   => false,
            'page_num'     => null,
            'url'          => null,
            'link_text'    => null,
            'is_prev_next' => false,
            'is_dots'      => false,
            'disabled'     => false, // 👈 новый флаг
        ];

        if ( 'dots' === $num ) {
            return (object) array_merge( $data, [
                'is_dots'   => true,
                'link_text' => '…',
            ] );
        }

        $is_prev = 'prev' === $num && ( $num = max( 1, $rg->current - 1 ) );
        $is_next = 'next' === $num && ( $num = min( $rg->total, $rg->current + 1 ) );

        $url = null;
        if ( ! $is_prev && ! $is_next ) {
            $url = ( 1 === $num ) ? $rg->first_url : str_replace( '{pagenum}', $num, $rg->url_base );
        }

        $data = array_merge( $data, [
            'is_current'   => ! ( $is_prev || $is_next ) && $num === $rg->current,
            'page_num'     => $num,
            'url'          => $url,
            'is_prev_next' => $is_prev || $is_next,
        ] );

        if ( $is_prev ) {
            $data['link_text'] = $rg->prev_text;
            // url для prev/next задаём отдельно, если активны
            if ( $rg->current > 1 ) {
                $data['url'] = ( $num === 1 ) ? $rg->first_url : str_replace( '{pagenum}', $num, $rg->url_base );
            } else {
                $data['disabled'] = true;
                $data['url'] = null; // или '#'
            }
        } elseif ( $is_next ) {
            $data['link_text'] = $rg->next_text;
            if ( $rg->current < $rg->total ) {
                $data['url'] = str_replace( '{pagenum}', $num, $rg->url_base );
            } else {
                $data['disabled'] = true;
                $data['url'] = null;
            }
        } else {
            $data['link_text'] = sprintf( $rg->a_text_patt, $num );
        }

        return (object) $data;
    };

    // Build list with dots
    $pages = [];
    foreach ( $active_nums as $i => $num ) {
        $pages[] = $item_data( $num );

        $next = $active_nums[ $i + 1 ] ?? null;
        if ( $next && $num + 1 !== $next ) {
            $pages[] = $item_data( 'dots' );
        }
    }

    // Add always-visible prev/next arrows (if enabled)
    if ( $rg->is_prev_next ) {
        array_unshift( $pages, $item_data( 'prev' ) );
        $pages[] = $item_data( 'next' );
    }

    return $pages;
}
