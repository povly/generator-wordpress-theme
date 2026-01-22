<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Глобальные поля для всех блоков
 */
acf_add_local_field_group(array(
    'key' => 'group_global_block_settings',
    'title' => 'Глобальные настройки блока',
    'fields' => array(
        array(
            'key' => 'field_global_lazy_loading_tab',
            'label' => 'Настройки загрузки',
            'type' => 'tab',
            'instructions' => '',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_global_enable_lazy_loading',
            'label' => 'Включить ленивую загрузку изображений',
            'name' => 'enable_lazy_loading',
            'type' => 'true_false',
            'instructions' => 'Изображения будут загружаться только при приближении к области видимости',
            'required' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'message' => 'Использовать lazy loading для изображений',
            'default_value' => 1,
            'ui' => 1,
            'ui_on_text' => 'Да',
            'ui_off_text' => 'Нет',
        ),
        array(
            'key' => 'field_global_enable_media_lazy_loading',
            'label' => 'Включить ленивую загрузку видео/iframe',
            'name' => 'enable_media_lazy_loading',
            'type' => 'true_false',
            'instructions' => 'Видео и iframe будут загружаться только при приближении к области видимости',
            'required' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'message' => 'Использовать lazy loading для видео/iframe',
            'default_value' => 1,
            'ui' => 1,
            'ui_on_text' => 'Да',
            'ui_off_text' => 'Нет',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'all',
            ),
        ),
    ),
    'menu_order' => 1000,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
