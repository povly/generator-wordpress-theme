@php
  $title = get_acf_block_field_value('service_title', $data);
  $description = get_acf_block_field_value('description', $data);
  $image_1 = get_acf_block_field_value('image_1', $data);
  $image_2 = get_acf_block_field_value('image_2', $data);
  $main_image = get_acf_block_field_value('main_image', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
  $images = [];
@endphp

<div {!! $attrs !!}>
  <div class="service-first">
    <div class="container">
      <div class="service-first__content">
        <div class="service-first__text">

          @if ($title)
            <h2 class="service-first__title section__title">{!! $title !!}</h2>
          @endif

          @if ($description)
            <div class="service-first__description">{!! $description !!}</div>
          @endif

          <button type="button" class="service-first__btn p-btn p-btn--blue modal__show"
                  data-modal="calculator">{{ __('Рассчитать стоимость', 'sinaev') }}</button>

          @if ($image_1 || $image_2)
            <div class="service-first__images">
              @if ($image_1)
                <div class="service-first__image img--full">
                  @php
                    $img = wp_get_attachment_image($image_1, 'full', false, [
                        'data-width' => 126,
                        'data-height' => 80,
                        'data-lazy' => $enable_lazy_loading,
                    ]);
                  @endphp
                  {!! $img !!}
                </div>
              @endif

              @if ($image_2)
                <div class="service-first__image img--full">
                  @php
                    $img2 = wp_get_attachment_image($image_2, 'full', false, [
                        'data-width' => 126,
                        'data-height' => 80,
                        'data-lazy' => $enable_lazy_loading,
                    ]);
                  @endphp
                  {!! $img2 !!}
                </div>
              @endif
            </div>
          @endif
        </div>

        @if ($main_image)
          <div class="service-first__main-image img--full">
            @php
              $img_main = wp_get_attachment_image($main_image, 'full', false, [
                  'data-width' => 300,
                  'data-height' => 340,
                  'data-lazy' => $enable_lazy_loading,
              ]);
            @endphp
            {!! $img_main !!}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
