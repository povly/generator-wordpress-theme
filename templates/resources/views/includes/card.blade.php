<a href="{{ $href }}" class="p-card p-card--{{ $backgroundColor }} {{ $class }}">
  <div class="p-card__top">
    <div class="p-card__num">/{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</div>
    <div class="p-card__arrow">
      <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.5 4H26M26 4V23.5M26 4L4 26" stroke="white" stroke-width="2"/>
      </svg>
    </div>
  </div>
  <div class="p-card__bottom">
    <div class="p-card__title">{{ $title }}</div>
    <div class="p-card__excerpt">{{ $description }}</div>
  </div>
</a>
