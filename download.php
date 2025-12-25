<?php
// download.php

// Получаем имя темы из параметра URL (обязательно проверяем!)
$themeName = $_GET['theme'] ?? null;

if (!$themeName) {
    die('Ошибка: не указано имя темы.');
}

// Очищаем имя темы — допускаем только буквы, цифры, дефисы, подчёркивания
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $themeName)) {
    die('Ошибка: недопустимые символы в имени темы.');
}

$outputBaseDir = 'output/';
$themeDir = $outputBaseDir . $themeName . '/';

if (!is_dir($themeDir)) {
    die('Ошибка: тема не найдена.');
}

// Имя ZIP-архива
$zipFilename = $themeName . '.zip';
$zipPath = $outputBaseDir . $zipFilename;

// Создаём ZIP-архив
$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die('Не удалось создать ZIP-архив.');
}

// Рекурсивное добавление файлов в архив
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($themeDir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($iterator as $file) {
    // Путь относительно папки темы
    $relativePath = substr($file->getRealPath(), strlen(realpath($themeDir)) + 1);
    $zip->addFile($file->getRealPath(), $relativePath);
}

$zip->close();

// Отправляем файл пользователю
if (file_exists($zipPath)) {
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipPath) . '"');
    header('Content-Length: ' . filesize($zipPath));
    readfile($zipPath);

    // Опционально: удаляем временный ZIP после скачивания
    // unlink($zipPath);
} else {
    die('Ошибка: архив не найден.');
}