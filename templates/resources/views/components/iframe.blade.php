@props([
  'src' => '',
  'width' => null,
  'height' => null,
  'lazy' => false,
  'lazy_native' => false
])

@if($lazy)
  <iframe class="lazy"
          src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxIiBoZWlnaHQ9IjEiPjwvc3ZnPg=="
          data-src="{{ $src }}"
          width="{{ $width }}"
          height="{{ $height }}"
          allowfullscreen
    {{ $attributes }}>
  </iframe>
@elseif($lazy_native)
  <iframe
    loading="lazy"
    src="{{ $src }}"
    width="{{ $width }}"
    height="{{ $height }}"
    allowfullscreen
    {{ $attributes }}>
  </iframe>
@else
  <iframe src="{{ $src }}"
          width="{{ $width }}"
          height="{{ $height }}"
          allowfullscreen
    {{ $attributes }}>
  </iframe>
@endif
