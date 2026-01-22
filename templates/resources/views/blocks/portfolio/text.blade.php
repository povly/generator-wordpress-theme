<section {!! $attrs !!}>
  @php
    $title = get_acf_block_field_value('title', $data);
    $texts = get_acf_block_repeater_value('texts', $data, ['text']);
    $gallery_ids = get_acf_block_field_value('gallery_ids', $data);
    $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
    $galleries = [];
  @endphp

  <div class="container">
    @if ($title)
      <h2 class="portfolio-text__title section__title">{{ $title }}</h2>
    @endif

    <div class="portfolio-text__block">
      @if ($texts)
        <div class="portfolio-text__desc">
          @foreach ($texts as $text_item)
            @if (isset($text_item['text']))
              <p>{{ $text_item['text'] }}</p>
            @endif
          @endforeach
        </div>
      @endif

      @if ($gallery_ids)
        <div class="portfolio-text__swiper">
          <div class="portfolio-text__swiper-main">
            <div class="swiper">
              <div class="swiper-wrapper">
                @foreach ($gallery_ids as $image_id)
                  <div class="swiper-slide">
                    <div class="portfolio-text__slide img--full">
                      @php
                        $img = wp_get_attachment_image(is_admin() ? $image_id['ID'] : $image_id, 'full', false, [
                            'data-width' => 300,
                            'data-height' => 205,
                            'data-lazy' => $enable_lazy_loading,
                        ]);
                        $galleries[] = $img;
                      @endphp
                      {!! $img !!}
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="portfolio-text__arrows">
              <div class="portfolio-text__arrow portfolio-text__arrow-left">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M8.56358 17.7197L9.50639 16.7769L3.12356 10.3941L18.4847 10.3941L18.4847 9.06089L3.12356 9.06089L9.50639 2.67805L8.56358 1.73524L0.571344 9.72748L8.56358 17.7197Z"
                    fill="#030405"/>
                </svg>
              </div>
              <div class="portfolio-text__arrow portfolio-text__arrow-right">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M11.4364 17.7197L10.4936 16.7769L16.8764 10.3941L1.51528 10.3941L1.51528 9.06089L16.8764 9.06089L10.4936 2.67805L11.4364 1.73524L19.4287 9.72748L11.4364 17.7197Z"
                    fill="#030405"/>
                </svg>
              </div>
            </div>
          </div>
          <div class="portfolio-text__swiper-thumb">
            <div class="swiper">
              <div class="swiper-wrapper">
                @foreach ($galleries as $gallery)
                  <div class="swiper-slide">
                    <div class="portfolio-text__thumb img--full">
                      {!! $gallery !!}
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>
