<?php
// Получаем данные из POST (от формы)
$themeName = $_POST['theme_name'] ?? 'MyTheme';
$themeURI = $_POST['theme_uri'] ?? 'https://povly.ru';
$author = $_POST['author'] ?? 'Anonymous';
$authorURI = $_POST['author_uri'] ?? 'https://povly.ru';
$text_domain = $_POST['text_domain'] ?? 'generator-theme';
$description = $_POST['description'] ?? 'A generated WordPress theme';

// Очистка и нормализация text_domain для использования в константах и функциях
// Заменяем недопустимые символы (например, дефисы, точки) на подчёркивания и приводим к ASCII
$sanitized_text_domain = preg_replace('/[^a-z0-9_]+/i', '_', $text_domain);
$sanitized_text_domain = trim($sanitized_text_domain, '_');

// Генерируем CONSTANT и FUNCTION
$constant_name = strtoupper($sanitized_text_domain);     // TEST_DOMAIN
$function_name = strtolower($sanitized_text_domain);    // test_domain

// Папки
$templatesDir = 'templates/';
$outputDir = 'output/' . $text_domain . '/';

// Создаём папку для новой темы
if (!mkdir($outputDir, 0755, true)) {
    die('Не удалось создать папку для темы.');
}

// Функция для рекурсивного копирования и замены
function generateTheme($src, $dest, $replacements) {
    $files = scandir($src);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $srcPath = $src . $file;
        $destPath = $dest . $file;

        if (is_dir($srcPath)) {
            mkdir($destPath, 0755, true);
            generateTheme($srcPath . '/', $destPath . '/', $replacements);
        } else {
            $content = file_get_contents($srcPath);
            foreach ($replacements as $key => $value) {
                $content = str_replace('{{' . $key . '}}', $value, $content);
            }
            file_put_contents($destPath, $content);
        }
    }
}

// Массив замен
$replacements = [
    'THEME_NAME' => $themeName,
    'THEME_URI' => $themeURI,
    'AUTHOR' => $author,
    'AUTHOR_URI' => $authorURI,
    'DESCRIPTION' => $description,
    'TEXT_DOMAIN' => $text_domain,
    'CONSTANT' => $constant_name,
    'FUNCTION' => $function_name
];

// Генерируем
generateTheme($templatesDir, $outputDir, $replacements);

echo "Тема '$themeName' успешно создана в папке $outputDir.<br>";
echo "<a href='download.php?theme=" . $text_domain . "'>Скачать ZIP</a>";
?>