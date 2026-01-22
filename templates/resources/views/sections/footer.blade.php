@php
  $footer_left_block = get_field('footer_left_block', 'options');
  $footer_socails = get_field('footer_social_networks', 'options');
  $footer_desc = get_field('footer_description', 'options');

  $mobile_menu = wp_get_nav_menu_items(3);

  $hierarchical_menu = buildMenuHierarchy($mobile_menu);

  $repair_title = get_field('repair_title_modal', 'option');
  $repair_gift_title = get_field('repair_gift_title', 'option');
  $repair_gift_text = get_field('repair_gift_text_modal', 'option');
  $repair_content = get_field('repair_content', 'option');
  $repair_gift_options = get_field('repair_gift_options', 'option');
@endphp
<footer class="footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-columns">
        <div class="footer-left">
          @if ($footer_left_block)
            @if (isset($footer_left_block['image']) && $footer_left_block['image'])
              @if (is_front_page())
                <div class="footer-logo">
                  {!! wp_get_attachment_image($footer_left_block['image'], 'full', false, [
                      'data-width' => 143,
                      'data-height' => 94,
                      'data-lazy' => true,
                  ]) !!}
                </div>
              @else
                <a href="/" class="footer-logo">
                  {!! wp_get_attachment_image($footer_left_block['image'], 'full', false, [
                      'data-width' => 143,
                      'data-height' => 94,
                      'data-lazy' => true,
                  ]) !!}
                </a>
              @endif
            @endif

            @if (isset($footer_left_block['phone']) && $footer_left_block['phone'])
              <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footer_left_block['phone']) }}"
                 class="footer-phone">{{ $footer_left_block['phone'] }}
              </a>
            @endif
          @endif
        </div>

        <div class="footer-right">
          @if ($footer_socails)
            <div class="footer-socials">
              @foreach ($footer_socails as $social)
                @php
                  $link = $social['link'];
                  $icon = $social['icon'];
                  $name = $social['name'];
                @endphp
                @if ($link)
                  <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                     class="footer-social" title="{{ $name ?: '' }}">
                    @if ($icon)
                      <span class="footer-social__icon">{!! $icon !!}</span>
                    @else
                      <span class="footer-social__name">{{ $name }}</span>
                    @endif
                  </a>
                @endif
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>


  <div class="footer-bottom">
    <div class="container">
      <div class="footer-bottom-content">
        <div class="footer-menus">
          <div class="footer-menu footer-menu--1">
            @if ($footer_desc)
              <div class="footer-description">
                {!! apply_filters('acf_the_content', $footer_desc) !!}
              </div>
            @endif

            @if (isset($footer_left_block['phone']) && $footer_left_block['phone'])
              <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footer_left_block['phone']) }}"
                 class="footer-phone">{{ $footer_left_block['phone'] }}</a>
            @endif


            {!! wp_nav_menu([
                'theme_location' => 'footer_menu_1',
                'container' => false,
                'menu_class' => 'footer-menu-list',
                'echo' => false,
                'walker' => new Footer_Walker_Nav_Menu(),
            ]) !!}
          </div>
          <div class="footer-menu footer-menu--3">
            {!! wp_nav_menu([
                'theme_location' => 'footer_menu_3',
                'container' => false,
                'menu_class' => 'footer-menu-list',
                'echo' => false,
                'walker' => new Footer_Walker_Nav_Menu(),
            ]) !!}
          </div>
          <div class="footer-menu footer-menu--4">
            {!! wp_nav_menu([
                'theme_location' => 'footer_menu_4',
                'container' => false,
                'menu_class' => 'footer-menu-list',
                'echo' => false,
                'walker' => new Footer_Walker_Nav_Menu(),
            ]) !!}
          </div>
        </div>

        @if ($footer_desc)
          <div class="footer-description">
            {!! apply_filters('acf_the_content', $footer_desc) !!}
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="footer-extra">
    <div class="container">
      <div class="footer-extra-content">
        <div class="footer-menu-link">
          {!! wp_nav_menu([
              'theme_location' => 'footer_menu_links',
              'container' => false,
              'menu_class' => 'footer-menu-links',
              'echo' => false,
          ]) !!}
        </div>
      </div>
    </div>
  </div>
</footer>
<div class="modal modal-menu modal_menu">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content modal-menu__content">
        <div class="modal__close modal-menu__close">
          @include('includes.menu.modal.close')
        </div>

        <div class="modal-menu__title">
          {{ __('Меню', 'sinaev') }}
        </div>

        <div class="modal-menu__list">
          @foreach ($hierarchical_menu as $item)
            <div class="modal-menu__item">
              <a href="{{ $item->url }}" class="modal-menu__link">
                <span>{{ $item->title ?: $item->post_title }}</span>

                @if ($item->child_items && count($item->child_items) > 0)
                  @include('includes.menu.modal.arrow')
                @endif
              </a>

              @if ($item->child_items && count($item->child_items) > 0)
                <div class="modal-menu__submenu">
                  <div class="modal-menu__submenu-top">
                    <div class="modal-menu__submenu-back">
                      @include('includes.menu.modal.back')
                    </div>
                    <div class="modal__title modal-menu__submenu-title">
                      {{ $item->title ?: $item->post_title }}
                    </div>
                    <div class="modal__close modal-menu__submenu-close">
                      @include('includes.menu.modal.close')
                    </div>
                  </div>

                  <div class="modal-menu__submenu-list">
                    @foreach ($item->child_items as $child_item)
                      <div class="modal-menu__submenu-item">
                        <a href="{{ $child_item->url }}" class="modal-menu__submenu-link">
                          <span>{{ $child_item->title ?: $child_item->post_title }}</span>
                          @if ($child_item->child_items && count($child_item->child_items) > 0)
                            @include('includes.menu.modal.arrow')
                          @endif
                        </a>

                        @if ($child_item->child_items && count($child_item->child_items) > 0)
                          <div class="modal-menu__submenu">
                            <div class="modal-menu__submenu-top">
                              <div class="modal-menu__submenu-back">
                                @include('includes.menu.modal.back')
                              </div>
                              <div class="modal__title modal-menu__submenu-title">
                                {{ $child_item->title ?: $child_item->post_title }}
                              </div>
                              <div class="modal__close modal-menu__submenu-close">
                                @include('includes.menu.modal.close')
                              </div>
                            </div>

                            <div class="modal-menu__submenu-list">
                              {!! renderSubmenu($child_item->child_items, 3) !!}
                            </div>
                          </div>
                        @endif
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
          @endforeach
        </div>


        <div class="modal-menu__bottom">
          @if (isset($footer_left_block['phone']) && $footer_left_block['phone'])
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footer_left_block['phone']) }}"
               class="modal-menu__phone">{{ $footer_left_block['phone'] }}
            </a>
          @endif

          <div class="footer-right">
            @if ($footer_socails)
              <div class="footer-socials">
                @foreach ($footer_socails as $social)
                  @php
                    $link = $social['link'];
                    $icon = $social['icon'];
                    $name = $social['name'];
                  @endphp
                  @if ($link)
                    <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                       class="footer-social" title="{{ $name ?: '' }}">
                      @if ($icon)
                        <span class="footer-social__icon">{!! $icon !!}</span>
                      @else
                        <span class="footer-social__name">{{ $name }}</span>
                      @endif
                    </a>
                  @endif
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="modal modal_calculator">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal_calculator__top">
          <div class="modal_calculator__back">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M18.5332 8.28806L7.09243 19.7289M7.09243 19.7289L18.5332 31.1697M7.09243 19.7289H32.9076"
                stroke="#030405" stroke-width="2"/>
            </svg>
          </div>

          <div class="modal__title modal_calculator__title">
            {!! $repair_title !!}
          </div>

          <div class="modal__close modal_calculator__close">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <rect width="38.8909" height="2.59272" rx="1.29636"
                    transform="matrix(0.707106 -0.707107 0.707106 0.707107 5.33301 32.833)"
                    fill="#A5CDED"/>
              <rect width="38.8909" height="2.59272" rx="1.29636"
                    transform="matrix(-0.707106 -0.707107 -0.707106 0.707107 34.667 32.833)"
                    fill="#A5CDED"/>
            </svg>
          </div>
        </div>

        <div class="modal_calculator__items">
          <div class="modal_calculator__item modal_calculator__item_1 active">
            <div class="modal_calculator__options p-form__inputs">
              @foreach ($repair_content as $key => $content)
                <div
                  class="modal_calculator__label modal_calculator__label--{!! $content['acf_fc_layout'] !!} p-form__input">
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
                              <label class="p-select__option"
                                     data-value="{!! $item['value'] !!}">
                                <input type="radio"
                                       name="calc[{!! $key !!}]"
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
                      <input type="text" name="calc[{!! $key !!}]"
                             value="{!! $content['content'] !!}">
                    @endif
                  </div>
                </div>
              @endforeach

              <div class="modal_calculator__label p-form__input p-form__input--btn">
                <button data-text-default="{{ __('Рассчитать', 'sinaev') }}"
                        data-text-second="{{ __('Новый расчёт', 'sinaev') }}" type="submit"
                        class="modal_calculator__submit p-btn p-btn--blue">
                  {{ __('Рассчитать', 'sinaev') }}
                </button>
              </div>
            </div>
          </div>

          <div class="modal_calculator__item modal_calculator__item_2">
            <div class="modal_know-price__items">

            </div>

            <div class="modal_know-price__total">
              <div class="modal_know-price__total-title">
                {{ __('Примерная стоимость:', 'sinaev') }}
              </div>
              <div class="modal_know-price__total-value">
                <span>0</span> рублей
              </div>
            </div>

            <div class="modal_calculator__subtitle">
              {!! $repair_gift_title !!}
            </div>

            <div class="modal_calculator__text">
              {!! $repair_gift_text !!}
            </div>

            <div class="modal_calculator__gift-list">
              @foreach ($repair_gift_options as $option_key => $option)
                <label for="calc-gift{{ $option_key }}" class="p-form__radio">
                  <input {{ $option_key === 0 ? 'checked' : '' }} id="calc-gift{{ $option_key }}"
                         type="radio" name="calc-gift" value="{!! $option['label'] !!}">
                  <span class="p-form__radio-circle"></span>
                  <span class="p-form__radio-text">
                                        {!! $option['label'] !!}
                                    </span>
                </label>
              @endforeach
            </div>

            {!! do_shortcode('[contact-form-7 id="6f2a84f" title="Калькулятор ремонта"]') !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-message modal_exit">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal__close">
          @include('includes.modal.close')
        </div>
        <div class="modal__title">
          {{ __('Спасибо за заявку', 'sinaev') }}
        </div>
        <div class="modal__text">
          {!! __(
              '<p>Мы получили ваш запрос на бесплатный выезд замерщика.</p>
                                                                                                                                                                                                                                                                                                                      <p>Наш специалист свяжется с вами в ближайшее время, чтобы согласовать удобную дату и время.</p>',
              'sinaev',
          ) !!}
        </div>
        <a href="{{ get_post_type_archive_link('portfolio') }}" class="modal__btn p-btn p-btn--blue">
          {{ __('Смотреть портфолио', 'sinaev') }}
        </a>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-message modal_faqs">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal__close">
          @include('includes.modal.close')
        </div>
        <div class="modal__title">
          {{ __('Спасибо за заявку', 'sinaev') }}
        </div>
        <div class="modal__text">
          {!! __(
              'Мы получили вашу заявку и скоро свяжемся с вами, чтобы ответить на вопросы и проконсультировать по возможным решениям.',
              'sinaev',
          ) !!}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-message modal_cons-message">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal__close">
          @include('includes.modal.close')
        </div>
        <div class="modal__title">
          {{ __('Спасибо за заявку', 'sinaev') }}
        </div>
        <div class="modal__text">
          {!! __(
              'Наш специалист свяжется с вами в ближайшее время, чтобы проконсультировать и помочь с вашим проектом.',
              'sinaev',
          ) !!}
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-form modal_cons">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal__close">
          @include('includes.modal.close')
        </div>

        {!! do_shortcode('[contact-form-7 id="e9f53e2" title="Нужна консультация?"]') !!}
      </div>
    </div>
  </div>
</div>

<div class="modal modal-form modal_outlay">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal__close">
          @include('includes.modal.close')
        </div>

        {!! do_shortcode('[contact-form-7 id="55e369f" title="Получите смету"]') !!}
      </div>
    </div>
  </div>
</div>
<div class="modal modal-message modal_outlay-message">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal__close">
          @include('includes.modal.close')
        </div>
        <div class="modal__title">
          {{ __('Спасибо за заявку', 'sinaev') }}
        </div>
        <div class="modal__text">
          {!! __('Мы отправим смету в ближайшее время!', 'sinaev') !!}
        </div>

        <a href="{{ get_post_type_archive_link('portfolio') }}" class="modal__btn p-btn p-btn--blue">
          {{ __('Смотреть портфолио', 'sinaev') }}
        </a>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-form modal_know-price">
  <div class="modal__table">
    <div class="modal__ceil">
      <div class="modal__content">
        <div class="modal__close">
          @include('includes.modal.close')
        </div>

        <div class="modal_know-price__title modal__title">
          {{ __('Узнать стоимость', 'sinaev') }}
        </div>

        <div class="modal_know-price__items">
        </div>

        <div class="modal_know-price__total">
          <div class="modal_know-price__total-title">
            {{ __('Примерная стоимость:', 'sinaev') }}
          </div>
          <div class="modal_know-price__total-value">
            <span>0</span> рублей
          </div>
        </div>

        {!! do_shortcode('[contact-form-7 id="dfeb6c4" title="Узнать стоимость"]') !!}
      </div>
    </div>
  </div>
</div>
