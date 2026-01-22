@php
  $title = get_acf_block_field_value('title', $data);
  $description = get_acf_block_field_value('description', $data);
  $slider = get_acf_block_repeater_value('slider', $data, ['image', 'text']);
  $button_text = get_acf_block_field_value('button_text', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
  $images = [];
@endphp

<div {!! $attrs !!}>
  <div class="container">
    <div class="main-first__block">

      <div class="main-first__text main-first__text-mb">
        <div class="main-first__title">
          {!! $title !!}
        </div>
        <div class="main-first__subtitle">
          {!! $description !!}
        </div>
      </div>

      @if ($slider && count($slider) > 0)

        <div class="main-first__slider">
          <div class="main-first__320">
            <div class="swiper">
              <div class="swiper-wrapper">
                @foreach ($slider as $key => $slide)
                  @php
                    $img = wp_get_attachment_image($slide['image'], 'full', false, [
                        'data-width' => 247,
                        'data-height' => 320,
                        'data-lazy' => $enable_lazy_loading,
                    ]);
                    $images[$slide['image']] = $img;
                  @endphp
                  <div class="swiper-slide">
                    <div class="main-first__image img--full">
                      {!! $img !!}
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="main-first__arrows">
              <button type="button" class="main-first__arrow main-first__arrow--left">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M24.3357 15.0391H5.58569M11.6794 8.47656L5.11694 15.0391L11.6794 21.6016"
                        stroke="#030405" stroke-width="1.875"/>
                </svg>
              </button>
              <div class="main-first__line"></div>
              <button type="button" class="main-first__arrow main-first__arrow--right">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.66431 15.0391H24.4143M18.3206 8.47656L24.8831 15.0391L18.3206 21.6016"
                        stroke="#030405" stroke-width="1.875"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="main-first__1024">
            <div class="main-first__1024-left">
              <div class="main-first__1024-main">
                <div class="swiper">
                  <div class="swiper-wrapper">
                    @foreach ($slider as $key => $slide)
                      <div class="swiper-slide">
                        <div class="main-first__image img--full">
                          {!! $images[$slide['image']] !!}
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="main-first__1024-thumb">
                <div class="main-first__text main-first__text-pc">
                  <div class="main-first__title">
                    {!! $title !!}
                  </div>
                  <div class="main-first__subtitle">
                    {!! $description !!}
                  </div>
                </div>

                <div class="swiper">
                  <div class="swiper-wrapper">
                    @php
                      $i = 0;
                    @endphp
                    @foreach ($slider as $key => $slide)
                      @if ($i !== 0)
                        <div class="swiper-slide">
                          <div class="main-first__thumb-image img--full">
                            {!! $images[$slide['image']] !!}
                          </div>
                        </div>
                      @endif
                      @php
                        $i++;
                      @endphp
                    @endforeach
                  </div>
                </div>
              </div>
            </div>


            <div class="main-first__arrows">
              <button type="button" class="main-first__arrow main-first__arrow--left">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M24.3357 15.0391H5.58569M11.6794 8.47656L5.11694 15.0391L11.6794 21.6016"
                        stroke="#030405" stroke-width="1.875"/>
                </svg>
              </button>
              <div class="main-first__line"></div>
              <button type="button" class="main-first__arrow main-first__arrow--right">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.66431 15.0391H24.4143M18.3206 8.47656L24.8831 15.0391L18.3206 21.6016"
                        stroke="#030405" stroke-width="1.875"/>
                </svg>
              </button>
            </div>
          </div>

          @if ($button_text)
            @include('includes.btn', [
                'element' => 'button',
                'class' => 'main-first__btn modal__show',
                'text' => $button_text,
                'type' => 'circle',
                'attrs' => [
                    'data-modal' => 'calculator',
                ],
            ])
          @endif

        </div>

      @endif

    </div>
  </div>
</div>
