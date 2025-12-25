<?php

use Illuminate\Support\Facades\Vite;

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('{{TEXT_DOMAIN}}-main', Vite::asset('resources/css/app.css'), [], null);
    wp_register_style('{{TEXT_DOMAIN}}-embla', Vite::asset('resources/css/components/embla.css'), [], null);
//    wp_enqueue_style('{{TEXT_DOMAIN}}-soon', Vite::asset('resources/css/blocks/soon.css'), ['{{TEXT_DOMAIN}}-main'], null);

    if (is_archive()){
        wp_enqueue_style('{{TEXT_DOMAIN}}-archive-base', Vite::asset('resources/css/blocks/main/blog/style.css'), ['{{TEXT_DOMAIN}}-main'], null);
        wp_enqueue_style('{{TEXT_DOMAIN}}-archive-extended', Vite::asset('resources/css/blocks/archive.css'), ['{{TEXT_DOMAIN}}-archive-base'], null);
    }

    $scripts = [
        'vanilla-lazyload' => [
            'src' => Vite::asset('resources/js/vanilla-lazyload.js'),
            'deps' => [],
        ],
//        'alpine' => [
//            'src' => Vite::asset('resources/js/alpine.js'),
//            'deps' => [],
//        ],
        'embla' => [
            'src' => Vite::asset('resources/js/embla.js'),
            'deps' => [],
        ],
        'main' => [
            'src' => Vite::asset('resources/js/app.js'),
            'deps' => ['vanilla-lazyload'],
        ],
    ];

    if (Vite::isRunningHot()) {
        foreach ($scripts as $name => $config) {
            $handle = '{{TEXT_DOMAIN}}-' . $name;
            $deps = array_map(function ($dep) {
                return '{{TEXT_DOMAIN}}-' . $dep;
            }, $config['deps']);

            wp_enqueue_script_module($handle, $config['src'], $deps, null, ['in_footer' => true]);
        }
    } else {
        foreach ($scripts as $name => $config) {
            $handle = '{{TEXT_DOMAIN}}-' . $name;
            $deps = array_map(function ($dep) {
                return '{{TEXT_DOMAIN}}-' . $dep;
            }, $config['deps']);

            if (isset($config['is_register']) && $config['is_register']) {
                wp_register_script($handle, $config['src'], $deps, null, true);
            } else {
                wp_enqueue_script($handle, $config['src'], $deps, null, true);
            }
        }
    }

    $blocks = [
        '{{TEXT_DOMAIN}}main-help' => [
            'is_styles' => true,
            'is_script' => true,
            'style_deps' => ['{{TEXT_DOMAIN}}-embla'],
            'script_deps' => ['{{TEXT_DOMAIN}}-embla']
        ],
    ];

    foreach ($blocks as $key => $block) {

        if (has_block($key) && !is_archive()) {

            $full_name = str_replace('/', '-', $key);

            $parts = explode('/', $key);
            $block_name = end($parts); // 'home-first'


            // Преобразуем 'home-first' в 'home/first' для пути к файлам
            $block_folder = str_replace('-', '/', $block_name); // 'home/first'


            $style_deps = isset($block['style_deps']) ? $block['style_deps'] : [];
            $script_deps = isset($block['script_deps']) ? $block['script_deps'] : [];

            if (!in_array('{{TEXT_DOMAIN}}-main', $script_deps)) {
                array_push($script_deps, '{{TEXT_DOMAIN}}-main');
            }

            if (!in_array('{{TEXT_DOMAIN}}-main', $style_deps)) {
                array_push($style_deps, '{{TEXT_DOMAIN}}-main');
            }

            if (isset($block['is_styles']) && $block['is_styles']) {
                wp_enqueue_style($full_name, Vite::asset('resources/css/blocks/' . $block_folder . '/style.css'), $style_deps, null);
            }
            if (isset($block['is_script']) && $block['is_script']) {
                if (Vite::isRunningHot()) {
                    wp_enqueue_script_module($full_name, Vite::asset('resources/js/blocks/' . $block_folder . '/index.js'), $script_deps, null, ['in_footer' => true]);
                } else {
                    wp_enqueue_script($full_name, Vite::asset('resources/js/blocks/' . $block_folder . '/index.js'), $script_deps, null, true);
                }
            }
        }
    }
});


function my_gutenberg_editor_styles()
{
    wp_enqueue_style(
        '{{TEXT_DOMAIN}}-admin',
        Vite::asset('resources/css/admin.css'),
        ['wp-edit-blocks']
    );
}

add_action('enqueue_block_editor_assets', 'my_gutenberg_editor_styles');
