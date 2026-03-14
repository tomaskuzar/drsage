<header class="banner">
  <div class="banner__inner">
    <a class="brand" href="{{ home_url('/') }}">
      <span class="brand__eyebrow">Deň rodiny</span>
      <span class="brand__title">{!! $siteName !!}</span>
    </a>

    @if (! empty($headerMenuItems))
      <nav class="nav-primary" aria-label="Hlavná navigácia">
        <ul class="nav">
          @foreach ($headerMenuItems as $item)
            <li class="nav__item">
              <a class="nav__link {{ $item['active'] ? 'nav__link--active' : '' }}" href="{{ $item['url'] }}">
                {{ $item['label'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </nav>
    @elseif (has_nav_menu('primary_navigation'))
      <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
      </nav>
    @endif

    @if (! empty($siteDescription))
      <p class="banner__tagline">{{ $siteDescription }}</p>
    @endif
  </div>
</header>
