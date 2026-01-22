<?php
// Функция для создания страницы опций ACF
function {{FUNCTION}}_create_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Настройки темы', // Заголовок страницы
            'menu_title' => 'Настройки темы', // Текст в меню
            'menu_slug' => 'theme-settings', // Слаг для URL
            'capability' => 'edit_posts', // Права доступа
            'position' => 2, // Позиция в меню
            'redirect' => false // Не перенаправлять
        ));
    }
}
add_action('acf/init', '{{FUNCTION}}_create_acf_options_page');

// Функция для создания вкладок и полей на странице опций ACF
function {{FUNCTION}}_add_acf_options_fields() {
    if (function_exists('acf_add_local_field_group')) {

        // Группа полей для вкладки "Общие"
        acf_add_local_field_group(array(
            'key' => 'group_theme_settings_general',
            'title' => 'Общие',
            'fields' => array(
                array(
                    'key' => 'field_translations',
                    'label' => 'Переводы',
                    'name' => 'translations',
                    'type' => 'repeater',
                    'instructions' => 'Добавьте переводы по ключу (для WPML)',
                    'required' => 0,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_translation_key',
                            'label' => 'Ключ',
                            'name' => 'key',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'field_translation_value',
                            'label' => 'Значение',
                            'name' => 'value',
                            'type' => 'text',
                            'required' => 1,
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));


        // Группа полей для вкладки "Меню"
        acf_add_local_field_group(array(
            'key' => 'group_theme_settings_modal_menu',
            'title' => 'Меню',
            'fields' => array(
                array(
                    'key' => 'field_modal_menu_copyright',
                    'label' => 'Текст Copyright',
                    'name' => 'modal_menu_copyright',
                    'type' => 'textarea',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-settings',
                    ),
                ),
            ),
            'menu_order' => 1,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        // Группа полей для вкладки "Подвал"
        acf_add_local_field_group(array(
            'key' => 'group_theme_settings_footer',
            'title' => 'Подвал',
            'fields' => array(
                array(
                    'key' => 'field_footer_form',
                    'label' => 'Форма',
                    'name' => 'footer_form',
                    'type' => 'group',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_form_title',
                            'label' => 'Заголовок',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_form_description',
                            'label' => 'Описание',
                            'name' => 'description',
                            'type' => 'textarea',
                        ),
                        array(
                            'key' => 'field_form_shortcode',
                            'label' => 'Шорткод формы',
                            'name' => 'shortcode',
                            'type' => 'text',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_footer_contacts',
                    'label' => 'Контакты',
                    'name' => 'contacts',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_contact_text',
                            'label' => 'Текст',
                            'name' => 'text',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_contact_link',
                            'label' => 'Ссылка',
                            'name' => 'link',
                            'type' => 'text',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_footer_socials',
                    'label' => 'Социальные сети',
                    'name' => 'socials',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_social_text',
                            'label' => 'Текст ссылки',
                            'name' => 'text',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_social_link',
                            'label' => 'Ссылка',
                            'name' => 'link',
                            'type' => 'text',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_footer_copyright',
                    'label' => 'Текст Copyright',
                    'name' => 'copyright',
                    'type' => 'textarea',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-settings',
                    ),
                ),
            ),
            'menu_order' => 2,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }
}
add_action('acf/init', '{{FUNCTION}}_add_acf_options_fields');
