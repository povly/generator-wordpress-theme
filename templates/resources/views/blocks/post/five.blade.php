<section {!! $attrs !!}>
  <div class="container">
    @php
      $title = get_acf_block_field_value('title', $data);
      $description = get_acf_block_field_value('description', $data);
      $image_id = get_acf_block_field_value('image', $data);
      $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
    @endphp

    <div class="post-five__title post-five__title_1 section__title">
      {{ $title }}
    </div>

    <div class="post-five__block">
      @if ($image_id)
        @php
          $img = wp_get_attachment_image($image_id, 'full', false, [
              'data-width' => 300,
              'data-height' => 364,
              'data-lazy' => $enable_lazy_loading,
          ]);
        @endphp
        <div class="post-five__image img--full">
          {!! $img !!}
        </div>
      @endif

      @if ($description)
        <div class="post-five__description">
          <div class="post-five__title post-five__title_2 section__title">
            {{ $title }}
          </div>
          {!! apply_filters('acf_the_content', $description) !!}
        </div>
      @endif
    </div>
  </div>
</section>
