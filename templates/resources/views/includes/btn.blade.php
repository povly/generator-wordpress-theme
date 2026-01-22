@php
  // Собираем классы
  $classes = 'p-btn';
  if (isset($type)) {
      $classes .= ' p-btn--' . $type;
  }
  if (isset($class)) {
      $classes .= ' ' . $class;
  }

  // Преобразуем остальные атрибуты в строку с экранированием и кавычками
  $attrString = collect($attrs)
      ->map(fn($value, $key) => $key . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"')
      ->implode(' ');

  // Добавляем class в конец (или начало — без разницы)
  if ($classes) {
      $attrString = 'class="' . htmlspecialchars(trim($classes), ENT_QUOTES, 'UTF-8') . '" ' . $attrString;
  }
@endphp

<{{ $element }} {!! $attrString !!}>
{!! $text !!}
</{{ $element }}>
