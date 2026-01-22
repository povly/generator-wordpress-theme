@php
  $contacts = get_field('header_contacts', 'option');

  $menu_items = wp_get_nav_menu_items('Шапка');

@endphp
<header class="header">
  <div class="container">
    <div class="header__block">
      <div class="header__left">
        @if (is_front_page())
          <div class="header__logo">
            {!! wp_get_attachment_image(get_field('header_logo', 'option'), 'full', false, [
                'data-width' => 76,
                'data-height' => 50,
            ]) !!}
          </div>
        @else
          <a href="/" class="header__logo">
            {!! wp_get_attachment_image(get_field('header_logo', 'option'), 'full', false, [
                'data-width' => 76,
                'data-height' => 50,
            ]) !!}
          </a>
        @endif

        {{ wp_nav_menu([
            'theme_location' => 'menu_header',
            'menu' => '',
            'container' => 'div',
            'container_class' => 'header__list',
            'container_id' => '',
            'menu_class' => 'menu',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul class="%2$s">%3$s</ul>',
            'depth' => 0,
            'walker' => new Header_Walker_Nav_Menu(),
        ]) }}
      </div>

      <div class="header__right">

        @if ($contacts && count($contacts) > 0)

          <div class="header__socials">
            @foreach ($contacts as $contact)
              @php
                $class = 'header__social';
                $class .= $contact['show_on_desktop'] ? ' header__social--pc' : '';
                $class .= $contact['show_on_mobile'] ? ' header__social--mobile' : '';
                $class .= $contact['text'] ? ' header__social--text' : '';
              @endphp

              <a href="{{ $contact['link'] }}" class="{{ $class }}">

                @if (isset($contact['svg']) && $contact['svg'])
                  {!! $contact['svg'] !!}
                @else
                  {!! $contact['text'] !!}
                @endif

              </a>
            @endforeach
          </div>

        @endif

        <button type="button" class="header__menu modal__show" data-modal="menu">

                    <span class="header__menu-svg">
                        <span class="header__menu-line"></span>
                        <span class="header__menu-line"></span>
                        <span class="header__menu-line"></span>
                    </span>
          <span class="header__menu-text">
                        {{ __('Меню', 'sinaev') }}
                    </span>

        </button>

      </div>
    </div>
  </div>
</header>
