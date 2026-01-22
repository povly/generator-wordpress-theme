<section {!! $attrs !!}>
  <div class="container">
    <div class="portfolio-first__block">
      @php
        $image_1 = get_acf_block_field_value('image_2', $data);
        $image_2 = get_acf_block_field_value('image_1', $data);
        $gallery = get_acf_block_field_value('gallery', $data);
        $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
        $attrs_list = get_field('portfolio_attributes', get_the_ID());
        $title = get_the_title(get_the_ID());
        $excerpt = get_the_excerpt(get_the_ID());
      @endphp

      <div class="portfolio-first__left">
        @if ($title)
          <div class="portfolio-first__title portfolio-first__title-mb section__title">
            {!! $title !!}
          </div>
        @endif
        @if ($image_1 && $image_2)
          <div class="portfolio-first__images">
            <div class="portfolio-first__image portfolio-first__image--left img--full">
              @php
                $img1 = wp_get_attachment_image($image_1, 'full', false, [
                    'data-width' => 320,
                    'data-height' => 200,
                    'data-lazy' => $enable_lazy_loading,
                ]);
              @endphp
              {!! $img1 !!}
            </div>
            <div class="portfolio-first__image portfolio-first__image--right img--full">
              @php
                $img2 = wp_get_attachment_image($image_2, 'full', false, [
                    'data-width' => 320,
                    'data-height' => 200,
                    'data-lazy' => $enable_lazy_loading,
                ]);
              @endphp
              {!! $img2 !!}
            </div>
            <div class="portfolio-first__line"></div>
            <div class="portfolio-first__image-attr portfolio-first__image-attr--left">
              {{ __('До', 'sinaev') }}
            </div>
            <div class="portfolio-first__image-attr portfolio-first__image-attr--right">
              {{ __('После', 'sinaev') }}
            </div>
          </div>
        @endif
      </div>

      <div class="portfolio-first__text">
        @if ($title)
          <div class="portfolio-first__title portfolio-first__title-pc section__title">
            {!! $title !!}
          </div>
        @endif

        <div class="portfolio-first__bottom">
          <div class="portfolio-first__bottom-left">
            @if ($attrs_list && count($attrs_list) > 0)
              <div class="portfolio-first__attrs p-portfolio__attrs">
                @foreach ($attrs_list as $attr)
                  <div class="portfolio-first__attr p-portfolio__attr">
                    <div class="portfolio-first__attr-inner">
                      <div class="p-portfolio__attr-title">{!! $attr['label'] ?? '' !!}</div>
                      <div class="p-portfolio__attr-text">{!! $attr['value'] ?? '' !!}</div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

            @if ($excerpt)
              <div class="portfolio-first__excerpt">
                {!! $excerpt !!}
              </div>
            @endif
          </div>

          @if ($gallery && is_array($gallery) && count($gallery) > 0)
            <div class="portfolio-first__galleries">
              <div class="portfolio-first__galleries-inner">
                @foreach ($gallery as $index => $image_id)
                  <a href="{{ wp_get_attachment_url($image_id) }}" data-lbwps-gid="gallery"
                     class="portfolio-first__gallery img--full">
                    @php
                      $img = wp_get_attachment_image($image_id, 'full', false, [
                          'data-width' => 93,
                          'data-height' => 68,
                          'data-lazy' => $enable_lazy_loading,
                      ]);
                    @endphp
                    {!! $img !!}
                  </a>
                @endforeach
              </div>
            </div>
          @endif
        </div>

        <div class="portfolio-first__btns p-btns">
          <button type="button" class="portfolio-first__cons portfolio-first__btn p-btn p-btn--blue modal__show"
                  data-modal="cons">
            {{ __('Получить консультацию', 'sinaev') }}
          </button>
          <button type="button" class="portfolio-first__calc portfolio-first__btn p-btn modal__show"
                  data-modal="calculator">
            {{ __('Калькулятор', 'sinaev') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
