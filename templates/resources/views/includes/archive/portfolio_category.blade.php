@php
  global $wp_query;
  global $wp;
  if ('' === get_option('permalink_structure')) {
      $form_action = remove_query_arg(
          ['page', 'paged'],
          add_query_arg($wp->query_string, '', home_url($wp->request)),
      );
  } else {
      $form_action = preg_replace('%\/page/[0-9]+%', '', home_url(user_trailingslashit($wp->request)));
  }
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  $terms = get_terms([
      'taxonomy' => 'portfolio_category',
      'hide_empty' => false,
      'orderby' => 'id',
      'order' => 'DESC',
  ]);
  $sorts = {{FUNCTION}}_get_sorts_array();
  $filters = get_option('pf_filters', []);
@endphp

<div class="container">
  @php
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p class="breadcrumbs">', '</p>');
    }
  @endphp
</div>

<form action="{{ $form_action }}" class="portfolio-first">
  <div class="container">
    <div class="portfolio-first__title section__title">
      {!! get_field('portfolio_additional_title', 'option') !!}
    </div>

    <div class="portfolio-first__top">
      <div class="p-tags portfolio-first__tags">
        <div class="p-tags__inner portfolio-first__tags-inner">
          @foreach ($terms as $key => $term)
            <label for="cat{{ $key }}" class="portfolio-first__tag p-tag">
              <input id="cat{{ $key }}" type="radio" name="pf_category"
                     value="{{ $term->slug }}"
                {{ request()->input('pf_category') == $term->slug ? 'checked' : '' }}>
              <span class="p-tag__text">{{ $term->name }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="portfolio-first__top-right">
        <div class="portfolio-first__filter">
          <div class="portfolio-first__filter-svg">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M17.5004 15V24.85C17.5504 25.225 17.4254 25.625 17.1379 25.8875C17.0223 26.0034 16.8849 26.0953 16.7337 26.158C16.5825 26.2208 16.4204 26.2531 16.2567 26.2531C16.0929 26.2531 15.9308 26.2208 15.7796 26.158C15.6284 26.0953 15.491 26.0034 15.3754 25.8875L12.8629 23.375C12.7267 23.2417 12.623 23.0787 12.5602 22.8987C12.4973 22.7187 12.4768 22.5267 12.5004 22.3375V15H12.4629L5.26291 5.775C5.05992 5.51441 4.96833 5.18407 5.00814 4.85616C5.04796 4.52825 5.21595 4.22943 5.47541 4.025C5.71291 3.85 5.97541 3.75 6.25041 3.75H23.7504C24.0254 3.75 24.2879 3.85 24.5254 4.025C24.7849 4.22943 24.9529 4.52825 24.9927 4.85616C25.0325 5.18407 24.9409 5.51441 24.7379 5.775L17.5379 15H17.5004Z"
                fill="#A5CDED"/>
            </svg>
          </div>
          <div class="portfolio-first__filter-text">
            {{ __('Фильтры', 'sinaev') }}
          </div>
        </div>

        <div class="p-select portfolio-first__sort">
          <div class="p-select__current">
            <div class="p-select__title">
              {{ request()->input('sort') ? $sorts[request()->input('sort')] ?? $sorts['new'] : $sorts['new'] }}
            </div>
            <div class="p-select__arrow">
              <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M1.35889 5.64887L1.83029 5.17747L5.02171 8.36888L5.02171 0.688306L5.68831 0.688306L5.68831 8.36888L8.87972 5.17747L9.35113 5.64887L5.35501 9.64499L1.35889 5.64887Z"
                  fill="#030405"/>
              </svg>
            </div>
          </div>
          <div class="p-select__abs">
            <div class="p-select__options">
              @foreach ($sorts as $key => $sort)
                <label for="sort{{ $key }}" class="p-select__option">
                  <input id="sort{{ $key }}" type="radio" name="sort"
                         value="{{ $key }}"
                    {{ request()->input('sort') == $key ? 'checked' : '' }}>
                  <div class="p-select__option-text">{{ $sort }}</div>
                </label>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    @if (have_posts())
      <div class="p-portfolios">
        @while (have_posts())
          @php
            $post = $wp_query->next_post();
            $href = get_permalink($post->ID);
            $img_id = get_post_thumbnail_id($post->ID);
            $content = get_the_excerpt($post); // или get_the_content(), но excerpt безопаснее

            $attrs_list = get_field('portfolio_attributes', $post->ID);
          @endphp

          @include('includes.portfolio', [
              'href' => $href,
              'img_id' => $img_id,
              'title' => $post->post_title,
              'content' => $content,
              'attrs' => $attrs_list,
              'enable_lazy_loading' => false,
          ])
        @endwhile
      </div>
    @else
      <div class="portfolio-first__no-found">
        {{ __('Нет записей в портфолио', 'sinaev') }}
      </div>
    @endif

    @if ($wp_query->max_num_pages > 1)
      <nav class="pagination">
        {!! paginate_links([
            'total' => $wp_query->max_num_pages,
            'current' => $paged,
            'format' => 'page/%#%',
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 1,
            'prev_next' => true,
            'prev_text' =>
                '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M6.63683 13.422L7.3675 12.6914L2.42081 7.74467H14.3257V6.71145H2.42081L7.3675 1.76475L6.63683 1.03407L0.44284 7.22806L6.63683 13.422Z" fill="#030405" /> </svg>',
            'next_text' =>
                '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.86317 13.422L8.1325 12.6914L13.0792 7.74467H1.1743V6.71145H13.0792L8.1325 1.76475L8.86317 1.03407L15.0572 7.22806L8.86317 13.422Z" fill="#030405" /> </svg>',
            'type' => 'plain',
            'add_args' => false,
        ]) !!}
      </nav>

      <button type="button" class="portfolio-first__show p-btn p-btn--ivory"
              data-ajax_url="{{ admin_url('admin-ajax.php') }}"
              data-nonce="{{ wp_create_nonce('portfolio_nonce') }}">
        {!! __('Загрузить ещё', 'sinaev') !!}
      </button>
    @endif
  </div>
  <div class="portfolio-filter">
    <div class="portfolio-filter__title section__title">
      {{ __('Фильтры', 'sinaev') }}
    </div>
    <button type="button" class="portfolio-filter__close">
      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="38.8909" height="2.59272" rx="1.29636"
              transform="matrix(0.707106 -0.707107 0.707106 0.707107 5.33398 32.833)" fill="#A5CDED"/>
        <rect width="38.8909" height="2.59272" rx="1.29636"
              transform="matrix(-0.707106 -0.707107 -0.707106 0.707107 34.666 32.833)" fill="#A5CDED"/>
      </svg>
    </button>
    <div class="portfolio-filter__block" data-simplebar data-simplebar-auto-hide="false">
      @foreach ($filters as $filter)
        @php
          $label = sanitize_text_field($filter['label']);
          $taxonomy_key = {{FUNCTION}}_generate_taxonomy_key($label);
        @endphp
        <div class="portfolio-filter__item {{ request()->input($taxonomy_key) ? 'active' : '' }}">
          <div class="portfolio-filter__item-top">
            <div class="portfolio-filter__item-title">
              {{ $label }}
            </div>
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M1.43565 7.90842L2.09561 7.24845L6.5636 11.7164L6.5636 0.963629L7.49683 0.963629L7.49683 11.7164L11.9648 7.24845L12.6248 7.90842L7.03021 13.503L1.43565 7.90842Z"
                fill="#030405"/>
            </svg>
          </div>
          <div class="portfolio-filter__item-content"
               style="{{ request()->input($taxonomy_key) ? 'height:auto;' : '' }}">
            <div class="portfolio-filter__item-inner">
              @if ($taxonomy_key === 'pf_ploshchad-kv-m')
                @php
                  $minmax = {{FUNCTION}}_get_taxonomy_min_max($taxonomy_key);
                @endphp
                <div class="p-form__range" data-min="{{ $minmax['min'] }}"
                     data-max="{{ $minmax['max'] }}">
                  <div class="p-form__range-line"></div>
                  <div class="p-form__range-inputs">
                    <div class="p-form__range-input">
                      <div class="p-form__range-text">От:</div>
                      <input type="text" name="{{ $taxonomy_key }}[min]"
                             value="{{ request()->input($taxonomy_key . '.min', $minmax['min']) }}"
                             class="p-form__range-value-min" id="{{ $taxonomy_key }}_min">
                    </div>
                    <div class="p-form__range-input">
                      <div class="p-form__range-text">До:</div>
                      <input type="text" name="{{ $taxonomy_key }}[max]"
                             value="{{ request()->input($taxonomy_key . '.max', $minmax['max']) }}"
                             class="p-form__range-value-max" id="{{ $taxonomy_key }}_max">
                    </div>
                  </div>
                </div>
              @else
                @php
                  $filter_values = get_terms([
                      'taxonomy' => $taxonomy_key,
                      'hide_empty' => false,
                  ]);
                @endphp
                <div class="p-form__checkboxes">
                  @foreach ($filter_values as $key => $term)
                    <label for="{{ $taxonomy_key }}{{ $key }}"
                           class="p-form__checkbox">
                      <input type="checkbox" name="{{ $taxonomy_key }}[]"
                             id="{{ $taxonomy_key }}{{ $key }}"
                             value="{{ $term->slug }}"
                        {{ request()->input($taxonomy_key) && in_array($term->slug, (array) request()->input($taxonomy_key)) ? 'checked' : '' }}>
                      <div class="p-form__checkbox-square">
                        <svg width="15" height="15" viewBox="0 0 15 15"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M5.62418 10.1252L3.43668 7.93766C3.37948 7.87976 3.31135 7.83379 3.23625 7.80241C3.16115 7.77104 3.08057 7.75488 2.99918 7.75488C2.91779 7.75488 2.83721 7.77104 2.76211 7.80241C2.68701 7.83379 2.61888 7.87976 2.56168 7.93766C2.50378 7.99486 2.45781 8.06298 2.42644 8.13808C2.39506 8.21319 2.37891 8.29377 2.37891 8.37516C2.37891 8.45655 2.39506 8.53713 2.42644 8.61223C2.45781 8.68733 2.50378 8.75546 2.56168 8.81266L5.18043 11.4314C5.42418 11.6752 5.81793 11.6752 6.06168 11.4314L12.6867 4.81266C12.7446 4.75546 12.7906 4.68733 12.8219 4.61223C12.8533 4.53713 12.8695 4.45655 12.8695 4.37516C12.8695 4.29377 12.8533 4.21319 12.8219 4.13809C12.7906 4.06298 12.7446 3.99486 12.6867 3.93766C12.6295 3.87976 12.5614 3.83379 12.4863 3.80241C12.4112 3.77104 12.3306 3.75488 12.2492 3.75488C12.1678 3.75488 12.0872 3.77104 12.0121 3.80241C11.937 3.83379 11.8689 3.87976 11.8117 3.93766L5.62418 10.1252Z"
                            fill="#030405"/>
                        </svg>
                      </div>
                      <span class="p-form__checkbox-text">
                                                 {{ $term->name }}
                                             </span>
                    </label>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="portfolio-filter__btns p-btns">
      <button type="submit" class="portfolio-filter__show p-btn p-btn--blue">
        {{ __('Показать', 'sinaev') }}
      </button>
      <button type="button" class="portfolio-filter__clear p-btn">
        {{ __('Очистить все', 'sinaev') }}
      </button>
    </div>
  </div>
</form>

@include('includes.services.form')

<div class="portfolio-seo section">
  <div class="container">
    <div class="portfolio-seo__title section__title">
      {!! get_field('portfolio_title', 'option') !!}
    </div>
    <div class="portfolio-seo__text">
      {!! apply_filters('acf_the_content', get_field('portfolio_desc', 'option')) !!}
    </div>
  </div>
</div>

<div class="overlay"></div>
