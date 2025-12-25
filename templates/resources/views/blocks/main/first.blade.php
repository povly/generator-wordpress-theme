@php
  $title = get_acf_block_field_value('title', $data);
  $description = get_acf_block_field_value('description', $data);
  $text_link = get_acf_block_field_value('text_link', $data);
  $text = get_acf_block_field_value('text', $data);
  $image_mobile = get_acf_block_field_value('image_mobile', $data);
  $image_desktop = get_acf_block_field_value('image_desktop', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
@endphp

<div {!! $attrs !!}>
  <div class="p-bg img--full img--adaptive first__bg">
    {!! wp_get_attachment_image($image_mobile, 'full', false, [
        'data-width' => 360,
        'data-height' => 580,
        'data-lazy' => $enable_lazy_loading
    ]) !!}
    {!! wp_get_attachment_image($image_desktop, 'full', false, [
        'data-width' => 1920,
        'data-height' => 800,
        'data-lazy' => $enable_lazy_loading
    ]) !!}
  </div>
  <div class="first__text">
    <div class="first__title section__title--white section__title">{{$title}}</div>
    <div class="first__subtitle">
      {!! is_admin() ? $description : e($description) !!}
    </div>
    <a href="{{$text_link}}" class="first__link p-link">
      {!! is_admin() ? $text : e($text) !!}
    </a>
  </div>
</div>