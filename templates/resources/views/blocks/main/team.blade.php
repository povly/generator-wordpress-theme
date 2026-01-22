@php
  $image_id = get_acf_block_field_value('image', $data);
  $title = get_acf_block_field_value('title', $data);
  $description = get_acf_block_field_value('description', $data);
  $image1_id = get_acf_block_field_value('image1', $data);
  $image2_id = get_acf_block_field_value('image2', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
@endphp

<div {!! $attrs !!}>
  <div class="container">
    <div class="main-team__grid">
      <div class="main-team__left">
        @if ($image_id)
          <div class="main-team__cover img--full">
            @php
              $img = wp_get_attachment_image($image_id, 'full', false, [
                  'data-width' => 300,
                  'data-height' => 434,
                  'data-lazy' => $enable_lazy_loading,
              ]);
            @endphp
            {!! $img !!}
          </div>
        @endif
      </div>

      <div class="main-team__right">
        @if ($title)
          <div class="main-team__title section__title">
            {!! $title !!}
          </div>
        @endif

        @if ($description)
          <div class="main-team__description">
            {!! $description !!}
          </div>
        @endif

        <div class="main-team__gallery">
          @if ($image1_id)
            <div class="main-team__gallery-item img--full">
              @php
                $img = wp_get_attachment_image($image1_id, 'full', false, [
                    'data-width' => 140,
                    'data-height' => 162,
                    'data-lazy' => $enable_lazy_loading,
                ]);
              @endphp
              {!! $img !!}
            </div>
          @endif

          @if ($image2_id)
            <div class="main-team__gallery-item img--full">
              @php
                $img = wp_get_attachment_image($image2_id, 'full', false, [
                    'data-width' => 87,
                    'data-height' => 162,
                    'data-lazy' => $enable_lazy_loading,
                ]);
              @endphp
              {!! $img !!}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
