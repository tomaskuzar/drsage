@php
  $startDate = function_exists('tribe_get_start_date') ? tribe_get_start_date(null, false, 'j. n. Y') : get_the_date('j. n. Y');
  $startTime = function_exists('tribe_get_start_date') ? tribe_get_start_date(null, false, 'H:i') : get_the_date('H:i');
  $endDateTime = function_exists('tribe_get_end_date') ? tribe_get_end_date(null, false, 'j. n. Y H:i') : '';
  $venue = function_exists('tribe_get_venue') ? tribe_get_venue() : '';
  $cost = function_exists('tribe_get_cost') ? tribe_get_cost(null, true) : '';
  $website = function_exists('tribe_get_event_website_url') ? tribe_get_event_website_url() : '';
  $eventsUrl = function_exists('tribe_get_events_link') ? tribe_get_events_link() : get_post_type_archive_link('tribe_events');
@endphp

<div class="page-shell event-single-shell">
  <article @php(post_class('page-article event-single'))>
    <header class="event-single__hero">
      <div class="event-single__hero-copy">
        <p class="page-header__eyebrow">Podujatie</p>
        <h1 class="page-header__title">{!! get_the_title() !!}</h1>

        @if (has_excerpt())
          <p class="page-header__excerpt">{{ get_the_excerpt() }}</p>
        @endif

        <div class="event-single__chips" aria-label="Základné informácie o podujatí">
          <span>{{ $startDate }}</span>
          <span>{{ $startTime }}</span>
          @if ($venue)
            <span>{{ $venue }}</span>
          @endif
        </div>
      </div>

      <aside class="event-single__hero-card">
        <p class="event-single__hero-label">Termín</p>
        <strong class="event-single__hero-number">{{ $startDate }}</strong>
        <p class="event-single__hero-text">Začiatok o {{ $startTime }}</p>

        @if ($eventsUrl)
          <a class="event-single__hero-link" href="{{ $eventsUrl }}">Všetky podujatia</a>
        @endif
      </aside>
    </header>

    <div class="event-single__layout">
      <div class="page-content">
        @php(the_content())
      </div>

      <aside class="event-single__sidebar" aria-label="Detaily podujatia">
        <div class="event-single__meta-card">
          <h2>Detaily</h2>

          <div class="event-single__meta">
            <p>
              <strong>Kedy:</strong>
              {{ function_exists('tribe_get_start_date') ? tribe_get_start_date(null, false, 'j. n. Y H:i') : get_the_date('j. n. Y H:i') }}
            </p>

            @if ($endDateTime)
              <p><strong>Do:</strong> {{ $endDateTime }}</p>
            @endif

            @if ($venue)
              <p><strong>Miesto:</strong> {{ $venue }}</p>
            @endif

            @if ($cost)
              <p><strong>Vstup:</strong> {{ $cost }}</p>
            @endif
          </div>
        </div>

        @if ($website)
          <div class="event-single__meta-card event-single__meta-card--accent">
            <h2>Viac info</h2>
            <p>Ak má podujatie vlastný odkaz alebo registráciu, nájdeš ju tu.</p>
            <a class="event-single__external-link" href="{{ $website }}" target="_blank" rel="noreferrer">
              Otvoriť stránku podujatia
            </a>
          </div>
        @endif
      </aside>
    </div>
  </article>
</div>
