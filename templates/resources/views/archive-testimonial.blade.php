@extends('layouts.app')

@section('header')
  @include('sections.header')
@endsection

@section('footer')
  @include('sections.footer')
@endsection


@section('content')
  @php
    global $wp_query;
    $videos = get_field('video_testimonials_list', 'option');
    $testimonials_title = get_field('testimonials_title', 'option');
    $testimonials_videos_title = get_field('testimonials_videos_title', 'option');
    $video_additional_title = get_field('video_additional_title', 'option');
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  @endphp

  <div class="reviews-video">
    <div class="container">
      <div class="reviews-video__title section__title">
        {{ $testimonials_title }}
      </div>
      <div class="reviews-video__subtitle section__title">
        {{ $testimonials_videos_title }}
      </div>
      <div class="reviews-video__items">
        <div class="swiper">
          <div class="swiper-wrapper">
            @foreach ($videos as $video)
              <div class="swiper-slide">
                <div class="reviews-video__item img--full">
                  @if ($video['type'] === 'iframe')
                    <iframe src="{{ $video['iframe_url'] }}"></iframe>
                  @else
                    <video src="{{ $video['mp4_url'] }}"></video>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="reviews-video__arrows">
          <button type="button" class="reviews-video__arrow reviews-video__arrow-left">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M8.56407 17.7197L9.50688 16.7769L3.12405 10.3941L18.4852 10.3941L18.4852 9.06089L3.12405 9.06089L9.50688 2.67805L8.56407 1.73524L0.571832 9.72748L8.56407 17.7197Z"
                fill="#030405"/>
            </svg>
          </button>
          <button type="button" class="reviews-video__arrow reviews-video__arrow-right">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                d="M11.4359 17.7197L10.4931 16.7769L16.876 10.3941L1.5148 10.3941L1.5148 9.06089L16.876 9.06089L10.4931 2.67805L11.4359 1.73524L19.4282 9.72748L11.4359 17.7197Z"
                fill="#030405"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="reviews-adds section">
    <div class="container">
      <div class="reviews-adds__title section__title">
        {{ $video_additional_title }}
      </div>
      @if (have_posts())
        <div class="reviews-adds__items">
          @while (have_posts())
            @php
              $testimonial = $wp_query->next_post();
              if ($testimonial) {
                  $testimonial_id = $testimonial->ID;
                  $testimonial_title = $testimonial->post_title;
                  $testimonial_content = $testimonial->post_content;
                  $testimonial_radio_field = get_field('testimonial_link_or_image', $testimonial_id);
                  $testimonial_link = get_field('testimonial_link', $testimonial_id);
                  $testimonial_image = get_field('testimonial_image', $testimonial_id);
                  $img = wp_get_attachment_image(get_post_thumbnail_id($testimonial_id), 'full', false, [
                      'data-width' => 80,
                      'data-height' => 80,
                      'data-lazy' => true,
                  ]);

                  // Determine which field to use based on radio button selection
                  if ($testimonial_radio_field === 'link') {
                      $display_content = $testimonial_link ? $testimonial_link : '';
                  } elseif ($testimonial_radio_field === 'image') {
                      $display_content = $testimonial_image
                          ? wp_get_attachment_url($testimonial_image)
                          : '';
                  }
              }
            @endphp

            <div class="reviews-adds__item">
              @if ($img)
                <div class="reviews-adds__image img--full">
                  {!! $img !!}
                </div>
              @endif
              <div class="reviews-adds__text">
                <div class="reviews-adds__top">
                  @if ($img)
                    <div class="reviews-adds__top-image img--full">
                      {!! $img !!}
                    </div>
                  @endif
                  <div
                    class="reviews-adds__top-text {{ !$img ? 'reviews-adds__top-text--no-image' : '' }}">
                    <div class="reviews-adds__item-date">
                      {{ \Carbon\Carbon::parse($testimonial->post_date)->format('d.m.Y') }} г.
                    </div>
                    <h3 class="reviews-adds__item-title">{{ $testimonial_title }}</h3>
                  </div>
                </div>
                <div class="reviews-adds__item-content">
                  {!! apply_filters('the_content', $testimonial_content) !!}
                </div>

                @if ($display_content)
                  <a href="{{ $display_content }}" class="reviews-adds__item-btn"
                     @if ($testimonial_radio_field === 'image') data-lbwps-gid="review" @endif>
                    @if ($testimonial_radio_field === 'link')
                      <span>{{ __('Смотреть отзыв', 'sinaev') }}</span>
                    @else
                      <span>{{ __('Читать отзыв', 'sinaev') }}</span>
                    @endif

                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M13.1764 11.6408H12.1098L12.1098 4.41947L3.42018 13.109L2.66602 12.3549L11.3556 3.6653H4.13424V2.59863H13.1764L13.1764 11.6408Z"
                        fill="#A5CDED"/>
                    </svg>
                  </a>
                @endif
              </div>
            </div>
          @endwhile
        </div>
      @else
        <div class="reviews-adds__no-found">
          {{ __('Нет записей в отзывах', 'sinaev') }}
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
        <button type="button" class="reviews-adds__btn p-btn p-btn--ivory"
                data-ajax_url="{{ admin_url('admin-ajax.php') }}" data-nonce="{{ wp_create_nonce('reviews_nonce') }}"
                data-max-pages="{{ $wp_query->max_num_pages }}">
          {{ __('Загрузить ещё', 'sinaev') }}
        </button>
      @endif
    </div>
  </div>

  @include('includes.services.form')
@endsection
