@extends('layouts.app')

@section('header')
  @include('sections.header')
@endsection

@section('footer')
  @include('sections.footer')
@endsection


@section('content')

  <div class="container">
    @php
      if (function_exists('yoast_breadcrumb')) {
          yoast_breadcrumb('<p class="breadcrumbs">', '</p>');
      }
    @endphp
  </div>

  @php
    $title = get_field('services_first_title', 'option');
    $categories = get_field('services_categories', 'option');
    $background_colors = get_field('services_first_background_colors', 'option');

    // Получаем объекты категорий по ID
    $categories_objects = [];
    if ($categories) {
        foreach ($categories as $category_id) {
            $term = get_term($category_id, 'services_cat');
            if ($term && !is_wp_error($term)) {
                $categories_objects[] = $term;
            }
        }
    }

    $i = 0;

    // Создаем массив фонов из ACF поля, если он заполнен
    $background = [];
    if ($background_colors) {
        foreach ($background_colors as $index => $bg_color) {
            $background[$index + 1] = $bg_color['color'];
        }
    } else {
        // Дефолтный массив, если не задано в ACF
        $background = [
            1 => 'blue',
            2 => 'white',
            3 => 'blue',
            4 => 'white',
            5 => 'white',
            6 => 'blue',
            7 => 'white',
            8 => 'blue',
            9 => 'white',
            10 => 'blue',
            11 => 'white',
            12 => 'blue',
            13 => 'blue',
        ];
    }
  @endphp


  <div class="services-first">
    <div class="container">

      @if ($title)
        <h2 class="services-first__title section__title">{!! $title !!}</h2>
      @endif

      @if (!empty($categories_objects))
        <div class="services-first__list">
          @foreach ($categories_objects as $category)
            <div class="services-first__item">
              <h3 class="services-first__item-title">{{ $category->name }}</h3>

              @php
                // Получаем услуги, принадлежащие данной категории
                $services_query = new WP_Query([
                    'post_type' => 'services',
                    'posts_per_page' => -1,
                    'tax_query' => [
                        [
                            'taxonomy' => 'services_cat',
                            'field' => 'term_id',
                            'terms' => $category->term_id,
                        ],
                    ],
                    'orderby' => 'date',
                    'order' => 'ASC',
                ]);

              @endphp

              @if ($services_query->have_posts())
                <ul class="services-first__cards p-cards">
                  @while ($services_query->have_posts())
                      <?php
                      $services_query->the_post();
                      $i++;
                      $current_bg = $background[$i] ?? $i % 2 === 0 ? 'white' : 'blue';
                      ?>
                    @include('includes.card', [
                        'num' => $i,
                        'class' => 'services-first__card',
                        'title' => get_the_title(),
                        'description' => get_the_excerpt(),
                        'backgroundColor' => $current_bg,
                        'href' => get_permalink(),
                    ])
                  @endwhile
                    <?php wp_reset_postdata(); ?>
                </ul>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  @include('includes.services.form')

@endsection
