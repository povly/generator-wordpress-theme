<section {!! $attrs !!}>
  @php
    $content = get_acf_flexible_content_value('content', $data, [
        'text_image' => ['title', 'description', 'image', 'reverse'],
        'title_desc_gallery' => ['title', 'description', 'gallery'],
        'image_description' => ['title', 'image', 'description'],
        'title_desc_gallery_full' => ['title', 'description', 'gallery'],
    ]);
    $title = get_acf_block_field_value('title', $data);
    $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
    $i = 0;
  @endphp

  <div class="container">
    <div class="portfolio-history__title section__title">
      {{ $title }}
    </div>
    @if ($content)
      <div class="portfolio-history__items">
        @foreach ($content as $layout)
          @php
            $i++;
          @endphp
          @switch($layout['acf_fc_layout'])
            @case('text_image')
              <div
                class="portfolio-history__item portfolio-history__item--text-image {{ $layout['reverse'] ? 'portfolio-history__item--reverse' : '' }}">
                <div class="portfolio-history__item-image img--full">
                  @if (isset($layout['image']) && $layout['image'])
                    @php
                      $img = wp_get_attachment_image($layout['image'], 'full', false, [
                          'data-width' => 300,
                          'data-height' => 213,
                          'data-lazy' => $enable_lazy_loading,
                      ]);
                    @endphp
                    {!! $img !!}
                  @endif
                </div>

                <div class="portfolio-history__item-content">
                  @if (isset($layout['title']) && $layout['title'])
                    <h3 class="portfolio-history__item-title">
                      <span>/{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                      <span>{{ $layout['title'] }}</span>
                    </h3>
                  @endif

                  @if (isset($layout['description']) && $layout['description'])
                    <div class="portfolio-history__item-description">
                      {!! apply_filters('acf_the_content', $layout['description']) !!}
                    </div>
                  @endif
                </div>
              </div>
              @break

            @case('title_desc_gallery')
              <div class="portfolio-history__item portfolio-history__item--title-desc-gallery">
                @if (isset($layout['title']) && $layout['title'])
                  <h3 class="portfolio-history__item-title">
                    <span>/{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ $layout['title'] }}</span>
                  </h3>
                @endif

                @if (isset($layout['description']) && $layout['description'])
                  <div class="portfolio-history__item-description">
                    {!! apply_filters('acf_the_content', $layout['description']) !!}
                  </div>
                @endif

                @if (isset($layout['gallery']) && $layout['gallery'])
                  <div class="portfolio-history__item-gallery">
                    @foreach ($layout['gallery'] as $image_id)
                      <div class="portfolio-history__item-gallery-el img--full">
                        @php
                          $img = wp_get_attachment_image($image_id, 'full', false, [
                              'data-width' => 87,
                              'data-height' => 122,
                              'data-lazy' => $enable_lazy_loading,
                          ]);
                        @endphp
                        {!! $img !!}
                      </div>
                    @endforeach
                  </div>
                @endif
              </div>
              @break

            @case('image_description')
              <div class="portfolio-history__item portfolio-history__item--image-description">

                <div class="portfolio-history__item-image img--full">
                  @if (isset($layout['image']) && $layout['image'])
                    @php
                      $img = wp_get_attachment_image($layout['image'], 'full', false, [
                          'data-width' => 300,
                          'data-height' => 364,
                          'data-lazy' => $enable_lazy_loading,
                      ]);
                    @endphp
                    {!! $img !!}
                  @endif
                </div>

                <div class="portfolio-history__text">
                  @if (isset($layout['title']) && $layout['title'])
                    <h3 class="portfolio-history__item-title">
                      <span>/{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                      <span>{{ $layout['title'] }}</span>
                    </h3>
                  @endif


                  @if (isset($layout['description']) && $layout['description'])
                    <div class="portfolio-history__item-description">
                      {!! apply_filters('acf_the_content', $layout['description']) !!}
                    </div>
                  @endif
                </div>
              </div>
              @break

            @case('title_desc_gallery_full')
              <div class="portfolio-history__item portfolio-history__item--title-desc-gallery-full">
                @if (isset($layout['title']) && $layout['title'])
                  <h3 class="portfolio-history__item-title">
                    <span>/{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ $layout['title'] }}</span>
                  </h3>
                @endif

                @if (isset($layout['description']) && $layout['description'])
                  <div class="portfolio-history__item-description">
                    {!! apply_filters('acf_the_content', $layout['description']) !!}
                  </div>
                @endif

                @if (isset($layout['gallery']) && $layout['gallery'])
                  <div class="portfolio-history__swiper">
                    <div class="swiper">
                      <div class="swiper-wrapper">
                        @foreach ($layout['gallery'] as $image_id)
                          <div class="swiper-slide">
                            <div class="portfolio-history__slide img--full">
                              @php
                                $img = wp_get_attachment_image(
                                    $image_id,
                                    'full',
                                    false,
                                    [
                                        'data-width' => 126,
                                        'data-height' => 80,
                                        'data-lazy' => $enable_lazy_loading,
                                    ],
                                );
                              @endphp
                              {!! $img !!}
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>

                    <div class="portfolio-history__arrows">
                      <div class="portfolio-history__arrow portfolio-history__arrow-left">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M8.56358 17.7197L9.50639 16.7769L3.12356 10.3941L18.4847 10.3941L18.4847 9.06089L3.12356 9.06089L9.50639 2.67805L8.56358 1.73524L0.571344 9.72748L8.56358 17.7197Z"
                            fill="#030405"/>
                        </svg>
                      </div>
                      <div class="portfolio-history__arrow portfolio-history__arrow-right">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M11.4364 17.7197L10.4936 16.7769L16.8764 10.3941L1.51528 10.3941L1.51528 9.06089L16.8764 9.06089L10.4936 2.67805L11.4364 1.73524L19.4287 9.72748L11.4364 17.7197Z"
                            fill="#030405"/>
                        </svg>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
              @break
          @endswitch
        @endforeach
      </div>
    @endif
  </div>
</section>
