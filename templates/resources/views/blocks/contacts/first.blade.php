<section {!! $attrs !!}>
  <div class="container">
    @php
      $title = get_acf_block_field_value('title', $data);
      $map = get_acf_block_field_value('map', $data);
      $contact_list = get_field('contact_list');
      $enable_lazy_loading = get_acf_block_field_value('enable_lazy_loading', $data);
    @endphp

    @if ($title)
      <div class="contacts-first__title section__title">{{ $title }}</div>
    @endif

    <div class="contacts-first__block">

      @if ($contact_list)
        <div class="contacts-first__info">
          @foreach ($contact_list as $contact)
            <div class="contacts-first__item">
              @if (isset($contact['contact_title']) && $contact['contact_title'])
                <h3 class="contacts-first__item-title">{{ $contact['contact_title'] }}</h3>
              @endif

              @if (isset($contact['contact_info']) && $contact['contact_info'])
                <div class="contacts-first__details">
                  @foreach ($contact['contact_info'] as $info)
                    <div class="contacts-first__detail">
                      @if (isset($info['subheader']) && $info['subheader'])
                        <h4 class="contacts-first__detail-subheader">{{ $info['subheader'] }}</h4>
                      @endif

                      @if (isset($info['social_links']) && $info['social_links'])
                        <div class="contacts-first__links">
                          @foreach ($info['social_links'] as $social)
                            @if (isset($social['social_url']) && $social['social_icon'])
                              <a href="{{ $social['social_url'] }}" target="_blank"
                                 class="contacts-first__link">
                                {!! $social['social_icon'] !!}
                              </a>
                            @endif
                          @endforeach
                        </div>
                      @else
                        @if (isset($info['description']) && $info['description'])
                          <div class="contacts-first__desc">{!! $info['description'] !!}</div>
                        @endif
                      @endif
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          @endforeach
        </div>
      @endif

      @if ($map)
        <div class="contacts-first__map">
          {!! $map !!}
        </div>
      @endif
    </div>
  </div>
</section>
