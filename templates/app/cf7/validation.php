<?php

add_filter('wpcf7_validate_tel*', '{{FUNCTION}}_custom_phone_validation', 20, 2);
add_filter('wpcf7_validate_tel', '{{FUNCTION}}_custom_phone_validation', 20, 2);

function {{FUNCTION}}_custom_phone_validation($result, $tag)
{
    $name = $tag->name;
    $value = isset($_POST[$name]) ? trim((string) $_POST[$name]) : '';

    if ($value !== '' && $value !== '0') {
        // Очищаем всё, кроме цифр
        $digits = preg_replace('/\D/', '', $value);

        // Проверяем длину: должно быть ровно 11 цифр (7 + 10 цифр номера)
        // И проверяем, что начинается на 7 или 8
        if (strlen((string) $digits) !== 11) {
            $result->invalidate($tag, 'Введите номер полностью в формате +7 (XXX) XXX-XX-XX');
        }
    }

    return $result;
}
