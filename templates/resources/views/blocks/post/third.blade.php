<section {!! $attrs !!}>
  <div class="container">
    <div class="post-third__block">
      @php
        $gallery = get_acf_block_field_value('gallery', $data);
        $description = get_acf_block_field_value('description', $data);
        $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
      @endphp


      @if ($description)
        <div class="post-third__description">
          {!! apply_filters('acf_the_content', $description) !!}
        </div>
      @endif

      @if ($gallery && is_array($gallery) && !empty($gallery))
        <div class="post-third__galleries">
          @foreach ($gallery as $image_id)
            @php
              $img = wp_get_attachment_image($image_id, 'full', false, [
                  'data-width' => 87,
                  'data-height' => 122,
                  'data-lazy' => $enable_lazy_loading,
              ]);
            @endphp
            <div class="post-third__gallery img--full">
              {!! $img !!}
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>
