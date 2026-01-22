<?php

if (! function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_main_first_block',
    'title' => 'Блок «Главная - 1 экран»',
    'fields' => [
        // Заголовок
        [
            'key' => 'field_main_first_title',
            'label' => 'Заголовок',
            'name' => 'title',
            'type' => 'text',
        ],
        // Описание
        [
            'key' => 'field_main_first_description',
            'label' => 'Описание',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'wpautop',
        ],
        // Повторитель слайдера
        [
            'key' => 'field_main_first_slider',
            'label' => 'Слайдер',
            'name' => 'slider',
            'type' => 'repeater',
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => 'Добавить слайд',
            'sub_fields' => [
                [
                    'key' => 'field_main_first_slide_image',
                    'label' => 'Изображение',
                    'name' => 'image',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ],
            ],
        ],
        // Текст кнопки
        [
            'key' => 'field_main_first_button_text',
            'label' => 'Текст кнопки',
            'name' => 'button_text',
            'type' => 'text',
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => '{{TEXT_DOMAIN}}/main-first',
            ],
        ],
    ],
]);
