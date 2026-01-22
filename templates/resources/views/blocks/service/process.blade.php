@php
  $title = get_acf_block_field_value('title', $data);
  $steps = get_acf_block_repeater_value('steps', $data, ['title', 'description', 'image']);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
@endphp

<section {!! $attrs !!}>
  <div class="container">
    @if ($title)
      <h2 class="service-process__title section__title">{!! $title !!}</h2>
    @endif

    @if ($steps)
      <div class="service-process__steps">
        @foreach ($steps as $key => $step)
          <div class="service-process__step">
            @if ($step['image'])
              <div class="service-process__step-image">
                @php
                  $img = wp_get_attachment_image($step['image'], 'full', false, [
                      'data-width' => 398,
                      'data-height' => 188,
                      'data-lazy' => $enable_lazy_loading,
                  ]);
                @endphp
                {!! $img !!}
              </div>
            @endif

            <div class="service-process__step-top">
              <div class="service-process__step-num">
                /{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}
              </div>
              @if ($step['title'])
                <h3 class="service-process__step-title">{!! $step['title'] !!}</h3>
              @endif
            </div>

            @if ($step['description'])
              <div class="service-process__step-description">{!! $step['description'] !!}</div>
            @endif
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
