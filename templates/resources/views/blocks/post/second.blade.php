<section {!! $attrs !!}>
  <div class="container">
    <div class="post-second__block">
      @php
        $title = get_acf_block_field_value('title', $data);
        $image = get_acf_block_field_value('image', $data);
        $description = get_acf_block_field_value('description', $data);
        $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
      @endphp

      <div class="post-second__text">
        @if ($description)
          <div class="post-second__description">
            {!! apply_filters('acf_the_content', $description) !!}
          </div>
        @endif
      </div>

      @if ($image)
        @php
          $img = wp_get_attachment_image($image, 'full', false, [
              'data-width' => 300,
              'data-height' => 188,
              'data-lazy' => $enable_lazy_loading,
          ]);
        @endphp
        <div class="post-second__image img--full">
          {!! $img !!}
        </div>
      @endif
    </div>
  </div>
</section>
