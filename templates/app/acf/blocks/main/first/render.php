<?php


/**
 * @param array $block   Блок с настройками.
 * @param string $content  (пустой)
 * @param bool $is_preview  true при предпросмотре
 * @param int $post_id      ID поста
 */

$attrs = isset($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
$attrs .= isset($block['className']) ? ' class="section first ' . esc_attr($block['className']) . '"' : 'class="section first"';


echo view('blocks.main.first', [
    'attrs' => $attrs,
    'data' => $block['data']
])->render();
