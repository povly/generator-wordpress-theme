<section {!! $attrs !!}>
  <div class="container">
    @php
      $gallery = get_acf_block_field_value('gallery', $data);
      $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
    @endphp

    @if ($gallery && is_array($gallery) && count($gallery))

      <div class="post-sliders__swiper">
        <div class="swiper">
          <div class="swiper-wrapper">
            @foreach ($gallery as $image_id)
              <div class="swiper-slide">
                @php
                  $img = wp_get_attachment_image($image_id, 'full', false, [
                      'data-width' => 280,
                      'data-height' => 209,
                      'data-lazy' => $enable_lazy_loading,
                  ]);
                @endphp
                <div class="post-sliders__slide img--full">
                  {!! $img !!}
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Swiper navigation arrows -->
        <div class="post-sliders__arrows">
          <div class="post-sliders__arrow-prev post-sliders__arrow">

            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M8.56554 17.7197L9.50835 16.7769L3.12551 10.3941L18.4867 10.3941L18.4867 9.06089L3.12551 9.06089L9.50835 2.67805L8.56554 1.73524L0.573297 9.72748L8.56554 17.7197Z"
                fill="#030405"/>
            </svg>
          </div>
          <div class="post-sliders__arrow-next post-sliders__arrow">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M11.4345 17.7197L10.4917 16.7769L16.8745 10.3941L1.51333 10.3941L1.51333 9.06089L16.8745 9.06089L10.4917 2.67805L11.4345 1.73524L19.4267 9.72748L11.4345 17.7197Z"
                fill="#030405"/>
            </svg>
          </div>

        </div>
      </div>
    @endif
  </div>
</section>
