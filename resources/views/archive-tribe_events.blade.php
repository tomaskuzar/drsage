@extends('layouts.app')

@section('content')
  @php($eventsCount = isset($wp_query) ? (int) $wp_query->found_posts : 0)

  <div class="page-shell">
    <section class="events-archive">
      <div class="events-archive__blob events-archive__blob--left" aria-hidden="true"></div>
      <div class="events-archive__blob events-archive__blob--right" aria-hidden="true"></div>

      <header class="events-archive__hero">
        <div class="events-archive__hero-copy">
          <p class="page-header__eyebrow">Kalendár podujatí</p>
          <h1 class="page-header__title">{{ post_type_archive_title('', false) ?: 'Podujatia' }}</h1>
          <p class="page-header__excerpt">
            Prehľad všetkých naplánovaných podujatí z The Events Calendar. Každý termín má vlastný detail s
            miestom, časom a ďalšími informáciami.
          </p>

          <div class="events-archive__chips" aria-label="Typy obsahu v kalendári">
            <span>Rodinné stretnutia</span>
            <span>Program pre deti</span>
            <span>Prehľad termínov</span>
          </div>
        </div>

        <aside class="events-archive__hero-card">
          <p class="events-archive__hero-label">Kalendár</p>
          <strong class="events-archive__hero-number">{{ $eventsCount }}</strong>
          <p class="events-archive__hero-text">
            {{ $eventsCount === 1 ? 'naplánované podujatie' : 'naplánované podujatia' }}
          </p>
          <a class="events-archive__hero-link" href="{{ home_url('/') }}">Späť na hlavnú stránku</a>
        </aside>
      </header>

      @if (have_posts())
        <div class="events-archive__grid" aria-label="Zoznam podujatí">
          @while(have_posts()) @php(the_post())
            <article @php(post_class('event-card'))>
              <a class="event-card__link" href="{{ get_permalink() }}">
                <div class="event-card__date">
                  <span class="event-card__month">
                    {{ function_exists('tribe_get_start_date') ? tribe_get_start_date(null, false, 'M') : get_the_date('M') }}
                  </span>
                  <strong class="event-card__day">
                    {{ function_exists('tribe_get_start_date') ? tribe_get_start_date(null, false, 'd') : get_the_date('d') }}
                  </strong>
                </div>

                <div class="event-card__body">
                  <h2 class="event-card__title">{!! get_the_title() !!}</h2>

                  <div class="event-card__meta">
                    <p>
                      <strong>Kedy:</strong>
                      {{ function_exists('tribe_get_start_date') ? tribe_get_start_date(null, false, 'j. n. Y H:i') : get_the_date('j. n. Y H:i') }}
                    </p>

                    @if (function_exists('tribe_get_venue') && tribe_get_venue())
                      <p><strong>Kde:</strong> {{ tribe_get_venue() }}</p>
                    @endif

                    @if (function_exists('tribe_get_cost') && tribe_get_cost())
                      <p><strong>Vstup:</strong> {{ tribe_get_cost(null, true) }}</p>
                    @endif
                  </div>

                  <div class="event-card__excerpt">
                    {{ wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 22) }}
                  </div>

                  <span class="event-card__cta">Pozrieť detail</span>
                </div>
              </a>
            </article>
          @endwhile
        </div>

        <nav class="events-archive__pagination" aria-label="Navigácia medzi podujatiami">
          {!! the_posts_pagination([
              'mid_size' => 1,
              'prev_text' => 'Predchádzajúce',
              'next_text' => 'Ďalšie',
              'echo' => false,
          ]) !!}
        </nav>
      @else
        <div class="events-archive__empty">
          <h2>Momentálne nie sú naplánované žiadne podujatia.</h2>
          <p>Keď pridáš eventy v The Events Calendar, zobrazia sa tu automaticky.</p>
        </div>
      @endif
    </section>
  </div>
@endsection
