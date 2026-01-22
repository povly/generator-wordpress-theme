<section {!! $attrs !!}>
  @php
    $title = get_acf_block_field_value('title', $data);
    $repeater = get_acf_block_repeater_value('repeater', $data, ['image', 'title', 'text']);
    $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
  @endphp

  <div class="container">
    @if ($title)
      <h2 class="service-approach__title section__title">{{ $title }}</h2>
    @endif

    @if ($repeater)
      <div class="service-approach__list">
        @foreach ($repeater as $item)
          <div class="service-approach__item">
            @if (isset($item['image']) && $item['image'])
              <div class="service-approach__item-img img--full">
                @php
                  $img = wp_get_attachment_image($item['image'], 'full', false, [
                      'data-width' => 260,
                      'data-height' => 252,
                      'data-lazy' => $enable_lazy_loading,
                  ]);
                @endphp
                {!! $img !!}
              </div>
            @endif

            @if (isset($item['title']))
              <h3 class="service-approach__item-title">{{ $item['title'] }}</h3>
            @endif

            @if (isset($item['text']))
              <p class="service-approach__item-text">{{ $item['text'] }}</p>
            @endif
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
