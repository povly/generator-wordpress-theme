@php
  $leader_text = get_acf_block_field_value('leader_text', $data);
  $fio = get_acf_block_field_value('fio', $data);
  $description = get_acf_block_field_value('description', $data);
  $image = get_acf_block_field_value('image', $data);
  $gallery = get_acf_block_repeater_value('gallery', $data, ['image', 'text']);

  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
@endphp


<div {!! $attrs !!}>
  <div class="container">
    <div class="main-director__block">
      <div class="main-director__text">
        <div class="main-director__image img--full">
          @php
            $img = wp_get_attachment_image($image, 'full', false, [
                'data-width' => 300,
                'data-height' => 234,
                'data-lazy' => $enable_lazy_loading,
            ]);@endphp
          {!! $img !!}
        </div>
        <div class="main-director__content">
          <div class="main-director__content-title">
            {!! apply_filters('acf_the_content', $fio) !!}
          </div>
          <div class="main-director__content-leader">

            {!! $leader_text !!}

          </div>

          <div class="main-director__content-text">

            {!! apply_filters('acf_the_content', $description) !!}

          </div>

        </div>
      </div>
      <div class="main-director__galleries">
        @foreach ($gallery as $item)
          <div class="main-director__gallery">
            <div class="main-director__gallery-el img--full">

              <div class="main-director__gallery-el-inner">
                @php
                  $img = wp_get_attachment_image($item['image'], 'full', false, [
                      'data-width' => 300,
                      'data-height' => 240,
                      'data-lazy' => $enable_lazy_loading,
                  ]);
                @endphp

                {!! $img !!}
              </div>
            </div>
            <div class="main-director__gallery-text">
              {!! $item['text'] !!}
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
