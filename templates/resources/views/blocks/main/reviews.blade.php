@php
  // Получаем поля блока (ACF)
  $title = $data['title'] ?? '';
  $source_type = $data['source_type'] ?? 'auto';
  $limit = isset($data['limit']) ? (int) $data['limit'] : 3;
  $selected_ids = !empty($data['selected']) ? (array) $data['selected'] : [];
  $enable_lazy_loading = !empty($data['enable_lazy_loading']);

  // Определяем, какие отзывы показывать
  if ($source_type === 'manual' && !empty($selected_ids)) {
      $reviews = get_posts([
          'post_type' => 'testimonial',
          'post__in' => $selected_ids,
          'orderby' => 'post__in',
          'posts_per_page' => -1,
      ]);
  } else {
      $reviews = get_posts([
          'post_type' => 'testimonial',
          'posts_per_page' => $limit,
          'orderby' => 'date',
          'order' => 'DESC',
      ]);
  }
@endphp

<div {!! $attrs !!}>
  <div class="container">
    @if ($title)
      <div class="main-reviews__title section__title">
        {!! esc_html($title) !!}
      </div>
    @endif

    @if (!empty($reviews))

      <div class="main-reviews__swiper">
        <div class="carousel-container" id="carouselContainer">
          <div class="carousel-track" id="carouselTrack">
            @foreach ($reviews as $review)
              @php
                $review_data = get_review_data($review->ID);
                $testimonial_id = $review->ID;
                $testimonial_radio_field = get_field('testimonial_link_or_image', $testimonial_id);
                $testimonial_link = get_field('testimonial_link', $testimonial_id);
                $testimonial_image = get_field('testimonial_image', $testimonial_id);
                $img = wp_get_attachment_image(get_post_thumbnail_id($testimonial_id), 'full', false, [
                    'data-width' => 80,
                    'data-height' => 80,
                    'data-lazy' => true,
                ]);

                // Determine which field to use based on radio button selection
                if ($testimonial_radio_field === 'link') {
                    $display_content = $testimonial_link ? $testimonial_link : '';
                } elseif ($testimonial_radio_field === 'image') {
                    $display_content = $testimonial_image
                        ? wp_get_attachment_url($testimonial_image)
                        : '';
                }
              @endphp
              <div class="carousel-slide">
                <div class="main-reviews__slide">
                  <div class="main-reviews__slide-bg img--full">
                    {!! wp_get_attachment_image($review_data['bg'], 'full', false, [
                        'data-width' => 280,
                        'data-height' => 203,
                        'data-lazy' => $enable_lazy_loading,
                    ]) !!}
                  </div>

                  <div class="main-reviews__slide-text">
                    @if (!empty($review_data['image']))
                      <div class="main-reviews__slide-avatar img--full">
                        {!! wp_get_attachment_image($review_data['image'], 'full', false, [
                            'data-width' => 60,
                            'data-height' => 72,
                            'data-lazy' => $enable_lazy_loading,
                        ]) !!}
                      </div>
                    @endif

                    <div class="main-reviews__slide-right">

                      <div class="main-reviews__slide-top">
                        @if (!empty($review_data['title']))
                          <div class="main-reviews__slide-title">
                            {!! $review_data['title'] !!}
                          </div>
                        @endif


                        <a href="{{ $display_content }}"
                           @if ($testimonial_radio_field !== 'link') data-lbwps-gid="review{{ $testimonial_id }}" @endif
                           class="main-reviews__slide-link">

                          <span>{{ $testimonial_radio_field === 'link' ? __('Читать отзыв', 'sinaev') : __('Смотреть отзыв', 'sinaev') }}</span>

                          <svg width="12" height="12" viewBox="0 0 12 12"
                               fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M9.8633 8.73086H9.06329V3.31484L2.54611 9.83203L1.98048 9.2664L8.49767 2.74922H3.08166V1.94922H9.8633V8.73086Z"
                              fill="#A5CDED"/>
                          </svg>
                        </a>
                      </div>

                      @if (!empty($review_data['text']))
                        <div class="main-reviews__slide-content">
                          {!! $review_data['text'] !!}
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="main-reviews__arrows">
          <button type="button" class="main-reviews__arrow main-reviews__arrow-left carousel-btn prev">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M8.56407 17.7197L9.50688 16.7769L3.12405 10.3941L18.4852 10.3941L18.4852 9.06089L3.12405 9.06089L9.50688 2.67805L8.56407 1.73524L0.571832 9.72748L8.56407 17.7197Z"
                fill="#030405"/>
            </svg>
          </button>
          <button type="button" class="main-reviews__arrow main-reviews__arrow-right carousel-btn next">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M11.4359 17.7197L10.4931 16.7769L16.876 10.3941L1.5148 10.3941L1.5148 9.06089L16.876 9.06089L10.4931 2.67805L11.4359 1.73524L19.4282 9.72748L11.4359 17.7197Z"
                fill="#030405"/>
            </svg>
          </button>
        </div>
      </div>
    @endif
  </div>
</div>
