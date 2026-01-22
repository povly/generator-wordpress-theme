@php
  $title = get_acf_block_field_value('title', $data);
  $desc = get_acf_block_field_value('desc', $data);
  $services = get_acf_block_repeater_value('services', $data, ['service_title', 'price', 'description']);
  $after_text = get_acf_block_field_value('after_text', $data);
  $image_id = get_acf_block_field_value('image', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
@endphp

<section {!! $attrs !!}>
  <div class="container">

    <div class="service-prices__block">
      @if ($image_id)
        <div class="service-prices__image img--full">
          @php
            $img = wp_get_attachment_image($image_id, 'full', false, [
                'data-width' => 126,
                'data-height' => 80,
                'data-lazy' => $enable_lazy_loading,
            ]);
          @endphp
          {!! $img !!}
        </div>
      @endif

      <div class="service-prices__text">

        @if ($title)
          <h2 class="service-prices__title section__title">{{ $title }}</h2>
        @endif

        @if ($desc)
          <div class="service-prices__desc">{{ $desc }}</div>
        @endif

        @if ($services)
          <div class="service-prices__list">
            @foreach ($services as $service)
              <div class="service-prices__item">
                <h3 class="service-prices__item-title">{{ $service['service_title'] ?? '' }}</h3>
                <div class="service-prices__item-price">{{ $service['price'] ?? '' }}</div>
              </div>
            @endforeach
          </div>
        @endif

        <div class="service-prices__bottom">
          @if ($after_text)
            <div class="service-prices__text-after">{{ $after_text }}</div>
          @endif

          <div class="service-prices__btns p-btns">
            <button type="button" class="service-prices__button p-btn p-btn--blue modal__show"
                    data-modal="outlay">{{ __('Получить смету', 'sinaev') }}</button>

            @if (!empty($data['button_text']) && !empty($data['button_url']))
              <a href="{{ $data['button_url'] }}"
                 class="service-prices__button p-btn p-btn--white">{{ $data['button_text'] }}</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
