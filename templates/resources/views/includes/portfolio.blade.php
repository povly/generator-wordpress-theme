<div class="p-portfolio">
  <a class="p-portfolio__img img--full" href="{!! $href !!}">
    @php
      $img = wp_get_attachment_image($img_id, 'full', false, [
          'data-width' => 3000,
          'data-height' => 2000, // было 200 — скорее всего опечатка
          'data-lazy' => $enable_lazy_loading ?? true,
      ]);
    @endphp
    {!! $img !!}
  </a>
  <div class="p-portfolio__bottom">
    <a href="{!! $href !!}" class="p-portfolio__bottom-top">
      <div class="p-portfolio__bottom-title">{!! $title !!}</div>
      <div class="p-portfolio__bottom-arrow">
        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.04545 6H24M24 6V21.9545M24 6L6 24" stroke="#A5CDED" stroke-width="2"/>
        </svg>
      </div>
    </a>
    @if (!empty($attrs))
      <div class="p-portfolio__attrs">
        @foreach ($attrs as $key => $attr)
          @if ($key <= 2)
            <div class="p-portfolio__attr">
              <div class="p-portfolio__attr-title">{!! $attr['label'] ?? '' !!}</div>
              <div class="p-portfolio__attr-text">{!! $attr['value'] ?? '' !!}</div>
            </div>
          @endif
        @endforeach
      </div>
    @endif
  </div>

  <div class="p-portfolio__hover">
    <a href="{!! $href !!}" class="p-portfolio__hover-top">
      <div class="p-portfolio__hover-title">{!! $title !!}</div>
      <div class="p-portfolio__hover-arrow">
        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
             xmlns="http://www.w3.org/2000/svg">
          <path d="M16.4464 3.44635L27.7279 14.7279M27.7279 14.7279L16.4464 26.0095M27.7279 14.7279H2.27208"
                stroke="#A5CDED" stroke-width="2"/>
        </svg>
      </div>
    </a>
    <a href="{!! $href !!}" class="p-portfolio__hover-text">{!! $content !!}</a>
    <div class="p-portfolio__hover-btns p-btns">
      <button class="p-btn p-btn--blue p-portfolio__btn modal__show" data-modal="cons"
              type="button">{!! __('Хочу также', 'sinaev') !!}</button>
      <a class="p-btn p-portfolio__btn" href="{!! $href !!}">{!! __('Смотреть проект', 'sinaev') !!}</a>
    </div>
  </div>
</div>
