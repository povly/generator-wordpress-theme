@php
  $shortcode = get_acf_block_field_value('shortcode', $data);
  $image1_id = get_acf_block_field_value('image1', $data);
  $image2_id = get_acf_block_field_value('image2', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
@endphp

<div {!! $attrs !!}>
  <div class="container">
    <div class="main-form__grid">
      <div class="main-form__left">
        @if ($shortcode)
          <div class="main-form__shortcode">
            {!! do_shortcode($shortcode) !!}
          </div>
        @endif
      </div>

      <div class="main-form__right">
        <div class="main-form__images-grid">
          @if ($image1_id)
            <div class="main-form__image-item img--full">
              @php
                $img1 = wp_get_attachment_image($image1_id, 'full', false, [
                    'data-width' => 277,
                    'data-height' => 350,
                    'data-lazy' => $enable_lazy_loading,
                ]);
              @endphp
              {!! $img1 !!}
            </div>
          @endif

          @if ($image2_id)
            <div class="main-form__image-item img--full">
              @php
                $img2 = wp_get_attachment_image($image2_id, 'full', false, [
                    'data-width' => 277,
                    'data-height' => 350,
                    'data-lazy' => $enable_lazy_loading,
                ]);
              @endphp
              {!! $img2 !!}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

