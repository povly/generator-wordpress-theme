@php
  $title = get_acf_block_field_value('title', $data);
  $source_type = get_acf_block_field_value('source_type', data: $data);
  $selected_ids = get_acf_block_field_value('selected', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);

  // Определяем, какие записи получить
  if ($source_type === 'manual' && isset($selected_ids) && count($selected_ids) > 0) {
      $portfolio_query = new WP_Query([
          'post_type' => 'portfolio',
          'post__in' => [$selected_ids],
          'posts_per_page' => 5,
      ]);
  } elseif ($source_type === 'similar_random') {
      // 'similar_random' — случайные записи из портфолио
      // Получаем категории портфолио текущей страницы
      $current_post_id = get_the_ID(); // ID текущей страницы/поста, где отображается блок
      $terms = wp_get_post_terms($current_post_id, 'portfolio_category', ['fields' => 'ids']);

      $args = [
          'post_type' => 'portfolio',
          'posts_per_page' => 5,
          'orderby' => 'rand',
          'post__not_in' => [$current_post_id], // исключаем текущий пост, если он типа portfolio
      ];

      if (!empty($terms)) {
          $args['tax_query'] = [
              [
                  'taxonomy' => 'portfolio_category',
                  'field' => 'term_id',
                  'terms' => $terms,
              ],
          ];
      }

      $portfolio_query = new WP_Query($args);
  } else {
      // 'auto' или fallback — последняя опубликованная запись
      $portfolio_query = new WP_Query([
          'post_type' => 'portfolio',
          'posts_per_page' => 5,
          'orderby' => 'date',
          'order' => 'DESC',
      ]);
  }
@endphp

@if ($portfolio_query->have_posts())
  <div {!! $attrs !!}>
    <div class="container">
      <div class="main-portfolio__title section__title">
        {!! $title !!}
      </div>

      <div class="main-portfolio__block">
        <div class="main-portfolio__items p-portfolios">
          @while ($portfolio_query->have_posts())
            @php
              $post = $portfolio_query->next_post();
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
                'enable_lazy_loading' => $enable_lazy_loading,
            ])
          @endwhile
          @php wp_reset_postdata(); @endphp

          <div class="p-portfolio p-portfolio--circle">
            <a href="{{ get_post_type_archive_link('portfolio') }}"
               class="main-portfolio__circle p-btn p-btn--circle">
              {!! __('Смотреть все&nbsp;проекты') !!}
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
@endif
