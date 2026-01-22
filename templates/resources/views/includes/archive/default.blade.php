@php
  global $wp_query;
  $parent = get_field('blog_category', 'option');
  $categories = get_terms([
      'taxonomy' => 'category',
      'hide_empty' => false,
      'parent' => $parent,
  ]);
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  $current_cat_id = get_queried_object_id();

  $all_category = get_term_by('id', $parent, 'category');
@endphp

<div class="container">
  @php
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p class="breadcrumbs">', '</p>');
    }
  @endphp
</div>

<div class="blog-first">
  <div class="container">
    <div class="blog-first__title section__title">
      {{ get_field('blog_title', 'option') }}
    </div>

    <div class="blog-first__tags p-tags">
      <div class="blog-first__tags-inner p-tags__inner">
        @php
          // Проверяем, активна ли родительская категория (все записи из неё или её архив)
          $is_all_active = false;

          $queried_cat_id = get_queried_object_id();
          if ($queried_cat_id == $parent) {
              $is_all_active = true;
          }

          $all_tag_class = 'p-tag blog-first__tag' . ($is_all_active ? ' active' : '');

        @endphp

        <a href="{{ get_term_link($all_category->term_id) }}" class="{{ $all_tag_class }}"
           data-id="{{ $all_category->term_id }}">
                    <span class="p-tag__text blog-first__tag-text">
                        {{ __('Все', 'sinaev') }}
                    </span>
        </a>

        @foreach ($categories as $category)
          @php
            $is_active = $category->term_id == $current_cat_id;
            $tag_class = 'p-tag blog-first__tag' . ($is_active ? ' active' : '');
          @endphp
          <a href="{{ get_term_link($category->term_id) }}" class="{{ $tag_class }}"
             data-id="{{ $category->term_id }}">
                        <span class="p-tag__text blog-first__tag-text">
                            {{ $category->name }}
                        </span>
          </a>
        @endforeach
      </div>
    </div>

    @if (have_posts())
      <div class="blog-first__items">
        @while (have_posts())
          @php
            $post = $wp_query->next_post();

          @endphp

          <a href="{{ get_permalink($post->ID) }}" class="blog-first__item">
                        <span class="blog-first__item-img img--full">
                            {!! wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'full', false, [
                                'data-width' => 300,
                                'data-height' => 189,
                                'data-lazy' => false,
                            ]) !!}
                        </span>
            <div class="blog-first__item-text">
              <div class="blog-first__item-top">
                                <span class="blog-first__item-title">
                                    {{ get_the_title($post->ID) }}
                                </span>
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.04545 6H24M24 6V21.9545M24 6L6 24" stroke="#A5CDED" stroke-width="2"/>
                </svg>
              </div>
              <span class="blog-first__item-desc">
                                {{ get_the_excerpt($post->ID) }}
                            </span>
              <span class="blog-first__item-btn p-btn p-btn--blue">
                                {{ __('Читать', 'sinaev') }}
                            </span>
            </div>
          </a>
        @endwhile
      </div>

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

        <button type="button" class="blog-first__show p-btn p-btn--ivory"
                data-ajax_url="{{ admin_url('admin-ajax.php') }}"
                data-nonce="{{ wp_create_nonce('blog_nonce') }}">
          {!! __('Загрузить ещё', 'sinaev') !!}
        </button>
      @endif
    @else
      <div class="blog-first__no-found">
        {{ __('Нет записей', 'sinaev') }}
      </div>
    @endif
  </div>
</div>

@include('includes.services.form')
