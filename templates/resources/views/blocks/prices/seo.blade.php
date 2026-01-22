<section {!! $attrs !!}>
  @php
    $title = get_acf_block_field_value('title', $data);
    $description = get_acf_block_field_value('description', $data);
    $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
  @endphp

  <div class="container">
    @if ($title)
      <h2 class="prices-seo__title section__title">{{ $title }}</h2>
    @endif

    @if ($description)
      <div class="prices-seo__text">
        {!! apply_filters('acf_the_content', $description) !!}
      </div>
    @endif
  </div>
</section>
