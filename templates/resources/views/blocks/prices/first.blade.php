<section {!! $attrs !!}>
  <div class="container">
    @php
      $title = get_acf_block_field_value('title', $data);
      $subtitle = get_acf_block_field_value('subtitle', $data);
      $services = get_field('services');
      $table_titles = get_field('prices_first_table_titles');
      $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
    @endphp

    @if ($title || $subtitle)
      <header class="prices-first__header">
        @if ($title)
          <h1 class="prices-first__title section__title">{{ $title }}</h1>
        @endif
        @if ($subtitle)
          <div class="prices-first__subtitle">{{ $subtitle }}</div>
        @endif
      </header>
    @endif

    @if ($services)
      <div class="prices-first__tags p-tags">
        <div class="p-tags__inner prices-first__tags-inner">
          @foreach ($services as $key => $service_group)
            @if (isset($service_group['tag']))
              <button data-key="{{ $key }}" type="button"
                      class="p-tag prices-first__tag-item {{ $key === 0 ? 'active' : '' }}">
                <div class="p-tag__text prices-first__tag-text">
                  {{ $service_group['tag'] }}
                </div>
              </button>
            @endif
          @endforeach
        </div>
      </div>

      <div class="prices-first__contents">
        @foreach ($services as $key => $service_group)
          <div class="prices-first__content {{ $key === 0 ? 'active' : '' }}" data-key="{{ $key }}">
            <div class="prices-first__tables">
              @foreach ($service_group['sections'] as $key_section => $section)
                <div class="prices-first__table">
                  <div class="prices-first__tr prices-first__tr--title">
                    @foreach ($table_titles as $table_title)
                      <div class="prices-first__td">
                        {{ $table_title['title'] }}
                      </div>
                    @endforeach
                  </div>
                  <div class="prices-first__tr prices-first__tr--subtitle {{$key_section === 0 ? 'active' : ''}}">
                    <div class="prices-first__td prices-first__td-list-title">
                      {{ $section['list_title'] }}
                    </div>
                    <div class="prices-first__td"></div>
                    <div class="prices-first__td prices-first__td-arrow">
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M1.84639 10.168L2.69492 9.31944L8.43947 15.064L8.43947 1.23895L9.63934 1.23895L9.63934 15.064L15.3839 9.31944L16.2324 10.168L9.03941 17.361L1.84639 10.168Z"
                          fill="#030405"/>
                      </svg>
                    </div>
                  </div>

                  <div class="prices-first__tr prices-first__tr--content" style="{{$key_section === 0 ? 'height:auto;' : ''}}">
                    <div class="prices-first__tr--content-inner">
                      @foreach ($section['table'] as $tr)
                        <div class="prices-first__attrs">
                          <div class="prices-first__td prices-first__td-name"
                               data-before="{{ $table_titles[0]['title'] }}">
                            <span>{{ $tr['service_name'] }}</span>
                          </div>
                          <div class="prices-first__td prices-first__td-unit"
                               data-before="{{ $table_titles[1]['title'] }}">
                                                        <span>
                                                            {{ $tr['unit'] }}
                                                        </span>
                          </div>
                          <div class="prices-first__td prices-first__td-price"
                               data-before="{{ $table_titles[2]['title'] }}">
                                                        <span>
                                                            {{ $tr['price'] }}
                                                        </span>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
