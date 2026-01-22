@php
  $title = get_acf_block_field_value('title', $data);

  $flexible_content = get_acf_flexible_content_value('content', $data, [
    'empty_card' => [],
    'image_card' => ['image'],
    'service_card' => ['service', 'custom_title', 'custom_description', 'color'],
    'button' => ['text', 'url', 'show_on_desktop', 'show_on_mobile'],
  ]);

  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);

  $i = 0;

@endphp

<div {!! $attrs !!}>
  <div class="container">
    <div class="main-services__title section__title">
      {!! $title !!}
    </div>

    @if($flexible_content && count($flexible_content) > 0)
      <div class="main-services__cards">
        @foreach ($flexible_content as $item)
          @if($item['acf_fc_layout'] === 'empty_card')

            <div class="main-services__card main-services__card--empty"></div>

          @elseif($item['acf_fc_layout'] === 'image_card')
            @php
              $img = wp_get_attachment_image($item['image'], 'full', false, [
                'data-width' => 300,
                'data-height' => 220,
                'data-lazy' => $enable_lazy_loading
              ]);
            @endphp
            <div class="main-services__card main-services__card--image img--full">
              {!! $img !!}
            </div>

          @elseif($item['acf_fc_layout'] === 'service_card')
            @php
              $i++;
              $args = array(
                'p' => $item['service'],
                'post_type' => 'services',
                'post_status' => 'publish'
              );

              $title = '';
              $description = '';
              $link = '';

              $service_query = new WP_Query($args);

              while ($service_query->have_posts()) {
                $service = $service_query->next_post();

                $title = $service->post_title;
                $description = $service->post_excerpt;
                $link = get_permalink($service->ID);
              }

              wp_reset_postdata();

            @endphp

            @include('includes.card', [
              'num' => $i,
              'class' => 'main-services__card main-services__card--default',
              'title' => isset($item['custom_title']) && !empty($item['custom_title']) ? $item['custom_title'] : $title,
              'description' => isset($item['custom_description']) && !empty($item['custom_description']) ? $item['custom_description'] : $description,
              'backgroundColor' => $item['color'],
              'href' => $link
            ])
          @elseif($item['acf_fc_layout'] === 'button')
            @php
              $class = '';
              if ($item['show_on_mobile']) {
                $class = ' main-services__card--link-mb';
              }
              if ($item['show_on_desktop']) {
                $class = ' main-services__card--link-pc';
              }
            @endphp
            <div class="main-services__card main-services__card--link{{ $class }}">
              @include('includes.btn', [
                'element' => 'a',
                'class' => 'main-first__link',
                'text' => $item['text'],
                'type' => 'circle',
                'attrs' => [
                  'href' => $item['url']
                ]
              ])
            </div>
          @endif

        @endforeach
      </div>
    @endif
  </div>
</div>
