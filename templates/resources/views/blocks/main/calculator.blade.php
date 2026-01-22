@php
  $repair_title = get_field('repair_title', 'option');
  $repair_gift_title = get_field('repair_gift_title', 'option');
  $repair_gift_text = get_field('repair_gift_text', 'option');
  $repair_content = get_field('repair_content', 'option');
  $repair_gift_options = get_field('repair_gift_options', 'option');
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
@endphp

<div {!! $attrs !!}>
  <div class="main-calculator__inner">
    <div class="container">
      <div class="main-calculator__title section__title">
        {!! $repair_title !!}
      </div>
      <div class="main-calculator__block">
        <div class="main-calculator__left">
          <div class="main-calculator__options p-form__inputs">
            @foreach ($repair_content as $key => $content)
              <div
                class="main-calculator__label main-calculator__label--{!! $content['acf_fc_layout'] !!} p-form__input">
                <div class="p-form__label">
                  {{ $content['title'] }}
                </div>
                <div class="p-form__input-el">
                  @if ($content['acf_fc_layout'] === 'heading_with_list')
                    @php
                      $items = $content['items'];
                    @endphp
                    <div class="p-select">
                      <div class="p-select__current">
                        <div class="p-select__title">
                          {!! $items[0]['text'] !!}
                        </div>
                        <div class="p-select__arrow">
                          <svg width="16" height="16" viewBox="0 0 16 16"
                               fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M1.52823 8.89171L2.28247 8.13746L7.38874 13.2437V0.954806H8.45529V13.2437L13.5616 8.13746L14.3158 8.89171L7.92202 15.2855L1.52823 8.89171Z"
                              fill="#030405"/>
                          </svg>
                        </div>
                      </div>
                      <div class="p-select__abs">
                        <div class="p-select__options">
                          @foreach ($items as $item_key => $item)
                            <label class="p-select__option" data-value="{!! $item['value'] !!}">
                              <input type="radio"
                                     name="calculator[{!! $key !!}]"
                                     value="{!! $item['text'] !!}"
                                {{ $item_key === 0 ? 'checked' : '' }}>
                              <span
                                class="p-select__option-text">{!! $item['text'] !!}</span>
                            </label>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  @else
                    <input type="text" name="calculator[{!! $key !!}]"
                           value="{!! $content['content'] !!}">
                  @endif
                </div>
              </div>
            @endforeach

            <div class="main-calculator__label p-form__input p-form__input--btn">
              <button data-text-default="{{ __('Рассчитать', 'sinaev') }}"
                      data-text-second="{{ __('Новый расчёт', 'sinaev') }}" type="submit"
                      class="main-calculator__submit p-btn p-btn--blue">
                {{ __('Рассчитать', 'sinaev') }}
              </button>
            </div>
          </div>
          <div class="main-calculator__total main-calculator__left-total">
            <div class="main-calculator__total-title">
              {{ __('Примерная стоимость ремонта:', 'sinaev') }}
            </div>

            <div class="main-calculator__total-price">
              <span>0</span> рублей
            </div>
          </div>
        </div>
        <div class="main-calculator__right">
          <div class="main-calculator__total main-calculator__right-total">
            <div class="main-calculator__total-title">
              {{ __('Примерная стоимость ремонта:', 'sinaev') }}
            </div>

            <div class="main-calculator__total-price">
              <span>0</span> рублей
            </div>
          </div>
          <div class="main-calculator__right-bottom">
            <div class="main-calculator__gift-title main-calculator__gift-title--1024_2">
              {!! $repair_gift_title !!}
            </div>
            <div class="main-calculator__gift-text">
              {!! $repair_gift_text !!}
            </div>
            <div class="main-calculator__gift-list">
              @foreach ($repair_gift_options as $option_key => $option)
                <label for="gift{{ $option_key }}" class="p-form__radio">
                  <input {{ $option_key === 0 ? 'checked' : '' }} id="gift{{ $option_key }}"
                         type="radio" name="gift" value="{!! $option['label'] !!}">
                  <span class="p-form__radio-circle"></span>
                  <span class="p-form__radio-text">
                                        {!! $option['label'] !!}
                                    </span>
                </label>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="main-calculator__gift-title main-calculator__gift-title--1024">
        {!! $repair_gift_title !!}
      </div>

      <button type="button" data-gift_title="{{ __('Подарок', 'sinaev') }}"
              class="main-calculator__bottom-btn p-btn p-btn--blue-dark modal__show" data-modal="know-price">
        {{ __('Узнать точную стоимость', 'sinaev') }}
      </button>
    </div>
  </div>
</div>
