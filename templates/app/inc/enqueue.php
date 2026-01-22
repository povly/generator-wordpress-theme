<?php

use Illuminate\Support\Facades\Vite;

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_style('{{TEXT_DOMAIN}}-main', Vite::asset('resources/css/app.css'), [], null);

    wp_register_style('{{TEXT_DOMAIN}}-swiper', Vite::asset('resources/css/components/swiper.css'), [], null);

    $scripts = [
        'vanilla-lazyload' => [
            'src' => Vite::asset('resources/js/vanilla-lazyload.js'),
            'deps' => [],
        ],
        'swiper' => [
            'src' => Vite::asset('resources/js/swiper.js'),
            'deps' => [],
            'is_register' => true,
        ],
        'main' => [
            'src' => Vite::asset('resources/js/app.js'),
            'deps' => ['vanilla-lazyload'],
        ],
    ];


    foreach ($scripts as $name => $config) {
        $handle = '{{TEXT_DOMAIN}}-'.$name;
        $deps = array_map(fn($dep) => '{{TEXT_DOMAIN}}-'.$dep, $config['deps']);

        wp_enqueue_script_module($handle, $config['src'], $deps, null, ['in_footer' => true]);
    }

    $blocks = {{FUNCTION}}_get_acf_blocks_with_enqueue();

    foreach ($blocks as $key => $block) {

        if (has_block($key) && ! is_archive()) {

            $full_name = str_replace('/', '-', $key);

            $parts = explode('/', (string) $key);
            $block_name = end($parts); // 'home-first'

            // Преобразуем 'home-first' в 'home/first' для пути к файлам
            $block_folder = str_replace('-', '/', $block_name); // 'home/first'

            $style_deps = $block['style_deps'] ?? [];
            $script_deps = $block['script_deps'] ?? [];

            if (! in_array('{{TEXT_DOMAIN}}-main', $script_deps)) {
                $script_deps[] = '{{TEXT_DOMAIN}}-main';
            }

            if (! in_array('{{TEXT_DOMAIN}}-main', $style_deps)) {
                $style_deps[] = '{{TEXT_DOMAIN}}-main';
            }

            if (isset($block['is_styles']) && $block['is_styles']) {
                wp_enqueue_style($full_name, Vite::asset('resources/css/blocks/'.$block_folder.'/style.css'), $style_deps, null);
            }
            if (isset($block['is_script']) && $block['is_script']) {
                wp_enqueue_script_module($full_name, Vite::asset('resources/js/blocks/'.$block_folder.'/index.js'), $script_deps, null, ['in_footer' => true]);
            }
        }
    }
});

function {{FUNCTION}}_gutenberg_editor_styles(): void
{
    wp_enqueue_style(
        '{{TEXT_DOMAIN}}-admin',
        Vite::asset('resources/css/admin.css'),
        ['wp-edit-blocks']
    );
}

add_action('enqueue_block_editor_assets', '{{FUNCTION}}_gutenberg_editor_styles');
