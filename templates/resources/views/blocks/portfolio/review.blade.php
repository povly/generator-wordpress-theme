<section {!! $attrs !!}>
  <div class="portfolio-review__inner">
    @php
      $title = get_acf_block_field_value('title', $data);
      $testimonials = get_acf_block_field_value('testimonials', $data);
      $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
    @endphp

    <div class="container">
      @if ($title)
        <h2 class="portfolio-review__title section__title">{{ $title }}</h2>
      @endif

      @if ($testimonials)
        <div class="portfolio-review__block">
          @foreach ($testimonials as $testimonial_id)
            @php
              $testimonial = get_post($testimonial_id);
              if ($testimonial) {
                  $testimonial_title = $testimonial->post_title;
                  $testimonial_content = $testimonial->post_content;
                  $testimonial_radio_field = get_field('testimonial_link_or_image', $testimonial_id);
                  $testimonial_link = get_field('testimonial_link', $testimonial_id);
                  $testimonial_image = get_field('testimonial_image', $testimonial_id);

                  // Determine which field to use based on radio button selection
                  if ($testimonial_radio_field === 'link') {
                      $display_content = $testimonial_link ? $testimonial_link : '';
                  } elseif ($testimonial_radio_field === 'image') {
                      $display_content = $testimonial_image
                          ? wp_get_attachment_url($testimonial_image)
                          : '';
                  }
              }
            @endphp

            <div class="portfolio-review__item">
              <h3 class="portfolio-review__item-title">{{ $testimonial_title }}</h3>
              <div class="portfolio-review__item-content">
                {!! apply_filters('the_content', $testimonial_content) !!}
              </div>

              @if ($display_content)
                <a href="{{ $display_content }}" class="portfolio-review__item-btn p-btn p-btn--blue"
                   @if ($testimonial_radio_field === 'image') data-lbwps-gid="review" @endif>
                  @if ($testimonial_radio_field === 'link')
                    {{ __('Смотреть отзыв', 'sinaev') }}
                  @else
                    {{ __('Читать отзыв', 'sinaev') }}
                  @endif
                </a>
              @endif


            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>
