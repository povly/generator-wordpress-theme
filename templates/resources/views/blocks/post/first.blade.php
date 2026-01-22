@php
  $title = get_acf_block_field_value('title', $data);
  $image = get_acf_block_field_value('image', $data);
  $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
  $post = get_post(get_the_ID());
@endphp

<section {!! $attrs !!}>
  <div class="container">
    <div class="post-first__block">
      <div class="post-first__date">
        {{ \Carbon\Carbon::parse($post->post_date)->format('d.m.Y') }} г.
      </div>
      @if ($title)
        <div class="post-first__title section__title">{{ $title }}</div>
      @endif

      @if ($image)
        @php
          $img = wp_get_attachment_image($image, 'full', false, [
              'data-width' => 320,
              'data-height' => 200,
              'data-lazy' => $enable_lazy_loading,
          ]);
        @endphp
        <div class="post-first__image img--full">
          {!! $img !!}
        </div>
      @endif
    </div>
  </div>
</section>
