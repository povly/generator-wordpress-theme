<section {!! $attrs !!}>
  @php
    $description = get_acf_block_field_value('description', $data);
    $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
  @endphp

  <div class="container">
    @if ($description)
      <div class="post-text__desc">
        {!! apply_filters('acf_the_content', $description) !!}
      </div>
    @endif
  </div>
</section>
