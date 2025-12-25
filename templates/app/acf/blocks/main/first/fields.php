<?php
if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group(array(
    'key' => 'group_main_first_block',
    'title' => 'Блок «Главная - 1 экран»',
    'fields' => array(
        // Изображение для телефона
        array(
            'key' => 'field_main_first_image_mobile',
            'label' => 'Изображение для телефона',
            'name' => 'image_mobile',
            'type' => 'image',
            'return_format' => 'id',
            'preview_size' => 'medium',
        ),
        // Изображение для ПК
        array(
            'key' => 'field_main_first_image_desktop',
            'label' => 'Изображение для ПК',
            'name' => 'image_desktop',
            'type' => 'image',
            'return_format' => 'id',
            'preview_size' => 'medium',
        ),
        // Заголовок
        array(
            'key' => 'field_main_first_title',
            'label' => 'Заголовок',
            'name' => 'title',
            'type' => 'text',
        ),
        // Описание
        array(
            'key' => 'field_main_first_description',
            'label' => 'Описание',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'wpautop',
        ),
        // Текст
        array(
            'key' => 'field_main_first_text',
            'label' => 'Текст',
            'name' => 'text',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'wpautop',
        ),
        // Ссылка текста
        array(
            'key' => 'field_main_first_text_link',
            'label' => 'Ссылка текста',
            'name' => 'text_link',
            'type' => 'text',
            'placeholder' => 'https://example.com',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => '{{TEXT_DOMAIN}}main-first',
            ),
        ),
    ),
));
