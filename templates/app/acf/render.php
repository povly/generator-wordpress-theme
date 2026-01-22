<?php

/**
 * @param  array  $block  Блок с настройками.
 * @param  string  $content  (пустой)
 * @param  bool  $is_preview  true при предпросмотре
 * @param  int  $post_id  ID поста
 */
function {{FUNCTION}}_acf_block_render(array $block, $content, $is_preview, $post_id): void
{
    $name = $block['name'];

    // Извлекаем часть после префикса '{{THEME_NAME}}/'
    $blockName = str_replace('{{TEXT_DOMAIN}}/', '', $name); // -> 'main-first'

    // Формируем путь к шаблону: заменяем '-' на '.'
    $templatePath = str_replace('-', '.', $blockName); // -> 'main.first'

    // Базовые классы: "section" + динамический класс из имени блока
    $baseClass = 'section '.$blockName; // -> 'section main-first'

    // Добавляем пользовательский className, если он есть
    $classNames = $baseClass;

    if (! empty($block['className'])) {
        $classNames .= ' '.esc_attr($block['className']);
    }

    $attrs = '';
    if (! empty($block['anchor'])) {
        $attrs .= ' id="'.esc_attr($block['anchor']).'"';
    }
    $attrs .= ' class="'.esc_attr($classNames).'"';

    echo view('blocks.'.$templatePath, [
        'attrs' => $attrs,
        'data' => $block['data'],
    ])->render();
}
