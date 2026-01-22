@php
  $title = get_acf_block_field_value('title', $data);
  $description = get_acf_block_field_value('description', $data);
  $cards = get_acf_flexible_content_value('cards', $data, [
      'image_card' => ['card_image'],
      'card_with_fields' => ['card_title', 'card_subtitle', 'card_description'],
  ]);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
  $i = 1;
@endphp

<section {!! $attrs !!}>
  <div class="container">
    @if ($title || $description)
      <div class="service-tired__header">
        @if ($title)
          <h2 class="service-tired__title section__title">{!! apply_filters('acf_the_content', $title) !!}</h2>
        @endif
        @if ($description)
          <div class="service-tired__description">{!! apply_filters('acf_the_content', $description) !!}</div>
        @endif
      </div>
    @endif

    @if ($cards)
      <div class="service-tired__cards">
        @foreach ($cards as $card)
          @php
            $layout = $card['acf_fc_layout'] ?? '';
            $class = '';
            if ($layout === 'card_with_fields') {
                $i++;
                $class = $i % 2 == 0 ? ' service-tired__card--left' : ' service-tired__card--right';
                $class .= ' service-tired__card--card_with_fields_' . $i;
            }
          @endphp
          <div class="service-tired__card service-tired__card--{{ $layout }}{{ $class }}">
            @if ($layout === 'image_card')
              @php
                $img = wp_get_attachment_image($card['card_image'], 'full', false, [
                    'data-width' => 204,
                    'data-height' => 224,
                    'data-lazy' => $enable_lazy_loading,
                ]);
              @endphp
              <div class="service-tired__card-image img--full">
                {!! $img !!}
              </div>
            @elseif($layout === 'card_with_fields')
              @php
                $card_title = $card['card_title'] ?? '';
                $card_subtitle = $card['card_subtitle'] ?? '';
                $card_description = $card['card_description'] ?? '';
              @endphp
              @if ($card_title)
                <h3 class="service-tired__card-title">{!! $card_title !!}</h3>
              @endif

              @if ($card_subtitle)
                <h4 class="service-tired__card-subtitle">{!! $card_subtitle !!}</h4>
              @endif

              @if ($card_description)
                <p class="service-tired__card-description">{!! $card_description !!}</p>
              @endif
            @endif
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
