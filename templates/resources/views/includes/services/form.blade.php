@php
  $shortcode = get_field('services_first_shortcode', 'option');
  $image1_id = get_field('services_form_image_1', 'option');
  $image2_id = get_field('services_form_image_2', 'option');
@endphp

<div class="main-form section">
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
                    'data-lazy' => true,
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
                    'data-lazy' => true,
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
