# Руководство по созданию ACF-блока

## Название и структура блока

Каждый ACF-блок должен следовать определенной структуре именования и файловой организации:

- **Название блока**: `main-first` (где `main` - категория, `first` - имя блока)
- **Путь к файлам блока**: `/wp-content/themes/sinaev/app/acf/blocks/main/first/`
- **Путь к шаблону**: `/wp-content/themes/sinaev/resources/views/blocks/main/first.blade.php`
- **Путь к стилям**: `/wp-content/themes/sinaev/resources/css/blocks/main/first/style.css`

## Структура файлов блока

Каждый ACF-блок должен содержать следующие файлы:

### 1. block.json

Файл конфигурации блока с метаданными:

```json
{
  "name": "sinaev/main-first",
  "title": "Главная - Первый экран",
  "description": "Блок Первый экран",
 "icon": "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='64px' height='64px'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' fill='#00000'/></svg>",
  "apiVersion": 3,
  "keywords": ["Первый экран", "главная"],
  "category": "sinaev",
  "acf": {
    "mode": "preview",
    "renderCallback": "{{FUNCTION}}_acf_block_render",
    "blockVersion": 3
  },
  "supports": {
    "align": true,
    "html": true,
    "jsx": true,
    "mode": true,
    "anchor": true
  }
}
```

### 2. fields.php

Файл определения полей ACF:

```php
<?php
if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group(array(
    'key' => 'group_main_first_block',
    'title' => 'Блок «Главная - 1 экран»',
    'fields' => array(
        // Примеры полей
        array(
            'key' => 'field_main_first_title',
            'label' => 'Заголовок',
            'name' => 'title',
            'type' => 'text',
        ),
        // Добавьте другие поля по необходимости
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'sinaev/main-first',
            ),
        ),
    ),
));
```

### 3. enqueue.php

Файл настройки зависимостей стилей и скриптов:

```php
<?php
return [
    'is_styles' => true,
    'is_script' => false,
    'style_deps' => [], // Зависимости стилей
    'script_deps' => [] // Зависимости скриптов
];
```

### 4. style.css

Файл стилей блока должен находиться по пути `/wp-content/themes/sinaev/resources/css/blocks/main/first/style.css` и
оставь пустым

## Использование функций для получения значений полей

Для получения значений из полей ACF используйте следующие функции, определенные в
`/wp-content/themes/sinaev/app/inc/functions.php`:

- `get_acf_block_field_value('field_name', $data)` - для получения значения обычного поля
- `get_acf_block_repeater_value('repeater_name', $data)` - для получения значений повторителя

* Пример вызова:
* $slider = get_acf_block_repeater_value('slider', $data, [
*       'image',
*       'text',
*       'advantages' => ['image', 'text'],
* ]);

- `get_acf_flexible_content_value('flexible_name', $data)` - для получения значений гибкого контента

* Пример вызова:
* $content = get_acf_flexible_content_value('content', $data, [
*       'image_card' => ['image'],
*       'service_card' => ['service', 'custom_title', 'custom_description'],
*       'button' => ['text', 'url'],
*       'empty_card' => [], // layout без полей
* ]);

Пример использования в шаблоне:

```php
$enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data); - это ставится в начала после всех acf полей
```

## Вывод изображений с поддержкой ленивой загрузки

Для вывода изображений используйте следующую конструкцию в шаблоне Blade:

```php
@php
$img = wp_get_attachment_image($image_1, 'full', false, [
    'data-width' => 126,
    'data-height' => 80,
    'data-lazy' => $enable_lazy_loading,
]);
@endphp
{!! $img !!}
```

В атрибутах изображения всегда передавайте параметр ленивой загрузки (`data-lazy`) для обеспечения единообразия
поведения изображений на сайте.

## Шаблон вывода

Шаблон блока должен находиться в `/wp-content/themes/sinaev/resources/views/blocks/main/first.blade.php` и использовать
вышеописанные функции для получения данных из полей ACF.

## Использование переменной $attrs в шаблонах

При создании шаблонов блоков вместо жестко заданных классов (например, `<section class="service-prices-block">`)
используйте переменную `$attrs`, которая содержит атрибуты, переданные из редактора WordPress:

```php
<section {!! $attrs !!}>
    <!-- Содержимое блока -->
</section>
```

Это позволяет использовать стандартные возможности WordPress для работы с блоками, такие как выравнивание, якоря и
другие атрибуты, которые могут быть добавлены через редактор.

## Подключение стилей блока в админке

После создания файла стилей для блока (например, `/wp-content/themes/sinaev/resources/css/blocks/main/first/style.css`),
необходимо подключить его в файле `/wp-content/themes/sinaev/resources/css/admin.css` внутри секции
`.wp-block-post-content`:

```css
.wp-block-post-content {
  /* ... другие импорты ... */
  @nested-import './blocks/main/first/style.css';
  /* Добавьте этот импорт для каждого нового блока */
}
```

Это обеспечит правильное отображение стилей блока в редакторе WordPress.
