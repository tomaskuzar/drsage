@extends('layouts.app')

@section('content')
  @php
    $highlights = [
        ['number' => '01', 'title' => 'Rodinné hry', 'text' => 'Hravé stanovištia a jednoduché aktivity pre malých aj veľkých.'],
        ['number' => '02', 'title' => 'Hudba a program', 'text' => 'Uvoľnená atmosféra, moderovaný program a spoločné momenty.'],
        ['number' => '03', 'title' => 'Oddych v parku', 'text' => 'Príjemný priestor na stretnutia, rozhovory a spoločný čas.'],
        ['number' => '04', 'title' => 'Občerstvenie', 'text' => 'Malé občerstvenie a pohodový záver dňa pod hradom.'],
    ];

    $bars = [
        ['label' => 'Hry a aktivity pre deti', 'value' => 96],
        ['label' => 'Oddych a spoločný čas', 'value' => 88],
        ['label' => 'Hudba a atmosféra', 'value' => 84],
    ];

    $cards = [
        ['title' => 'Rodinné súťaže', 'text' => 'Krátke aktivity, do ktorých sa môžete zapojiť priebežne počas podujatia.'],
        ['title' => 'Skákací hrad', 'text' => 'Obľúbený priestor pre deti a zároveň voľnejší rytmus pre rodičov.'],
        ['title' => 'Spoločné aktivity', 'text' => 'Tvorivé a pohybové momenty, ktoré prepájajú celé rodiny.'],
        ['title' => 'Hudba a chill zóna', 'text' => 'Miesto na vydýchnutie, rozhovory a nenútené zakončenie popoludnia.'],
    ];

    $schedule = [
        ['time' => '16.00', 'title' => 'Otvorenie podujatia', 'text' => 'Privítanie rodín a otvorenie popoludnia v parku.'],
        ['time' => '16.15', 'title' => 'Rodinné hry pre deti', 'text' => 'Stanovištia, malé výzvy a spoločné úlohy pre rodiny.'],
        ['time' => '16.45', 'title' => 'Skákací hrad', 'text' => 'Voľná zábava pre deti a priestor na oddych.'],
        ['time' => '17.15', 'title' => 'Spoločné aktivity pre rodiny', 'text' => 'Krátke bloky, do ktorých sa dá pripojiť bez stresu.'],
        ['time' => '17.45', 'title' => 'Hudba a občerstvenie', 'text' => 'Pohodová atmosféra a stretnutia pri hudbe.'],
        ['time' => '18.00', 'title' => 'Ukončenie', 'text' => 'Záver programu a poďakovanie návštevníkom aj partnerom.'],
    ];

    $partners = [
        'Logo partnera',
        'Logo partnera',
        'Logo partnera',
        'Logo partnera',
        'Logo partnera',
        'Logo partnera',
        'Logo partnera',
        'Logo partnera',
    ];
  @endphp

  <section class="den-home" aria-labelledby="den-hero-title">
    <div class="den-home__blob den-home__blob--left" aria-hidden="true"></div>
    <div class="den-home__blob den-home__blob--right" aria-hidden="true"></div>

    <div class="den-home__inner">
      <section class="den-home__hero">
        <div class="den-home__hero-copy">
          <p class="den-home__eyebrow">Vitajte na Deň rodiny</p>
          <h1 class="den-home__title" id="den-hero-title">
            Nesme sa <span>navzájom</span> a zažime spolu príjemné popoludnie.
          </h1>
          <p class="den-home__lead">
            Rodinné stretnutie plné hier, hudby, oddychu a spoločných aktivít v Parku pod hradom.
            Príďte sa zastaviť na chvíľu alebo zostaňte s nami celé popoludnie.
          </p>

          <div class="den-home__actions">
            <a class="den-home__button den-home__button--primary" href="#program">Program dňa</a>
            <a class="den-home__button den-home__button--ghost" href="#partneri">Partneri</a>
          </div>

          <div class="den-home__microcopy">
            <span>17. máj</span>
            <span>Park pod hradom</span>
            <span>Vstup voľný</span>
          </div>
        </div>

        <div class="den-home__hero-media" aria-hidden="true">
          <div class="den-home__hero-ring"></div>
          <div class="den-home__hero-ticket">
            <strong>17. máj</strong>
            <span>Park pod hradom</span>
          </div>

          <div class="den-home__hero-visual">
            <svg viewBox="0 0 640 540" role="presentation">
              <defs>
                <filter id="familyShadow" x="-20%" y="-20%" width="140%" height="140%">
                  <feDropShadow dx="0" dy="26" stdDeviation="24" flood-color="#78a7c4" flood-opacity=".18" />
                </filter>
                <linearGradient id="bodyLeft" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#efe1da" />
                  <stop offset="100%" stop-color="#dfcdc6" />
                </linearGradient>
                <linearGradient id="bodyRight" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#f0e1db" />
                  <stop offset="100%" stop-color="#e0cec6" />
                </linearGradient>
              </defs>

              <g filter="url(#familyShadow)">
                <ellipse cx="320" cy="474" rx="188" ry="24" fill="#e6f4fb" />
              </g>

              <circle cx="320" cy="228" r="180" fill="#f7fbff" />

              <g transform="translate(82 92)">
                <circle cx="88" cy="54" r="45" fill="#d8b3a4" />
                <path d="M40 96c10-20 34-32 58-32s50 11 60 36l10 148H22Z" fill="url(#bodyLeft)" />
                <rect x="12" y="118" width="38" height="142" rx="19" fill="#e8d8d2" transform="rotate(8 12 118)" />
                <rect x="126" y="116" width="38" height="140" rx="19" fill="#e8d8d2" transform="rotate(-8 126 116)" />
                <rect x="36" y="238" width="44" height="170" rx="18" fill="#4d6f98" transform="rotate(2 36 238)" />
                <rect x="102" y="236" width="44" height="172" rx="18" fill="#4d6f98" transform="rotate(-4 102 236)" />
                <rect x="28" y="400" width="56" height="24" rx="12" fill="#ffffff" />
                <rect x="96" y="404" width="56" height="24" rx="12" fill="#ffffff" />
              </g>

              <g transform="translate(398 86)">
                <circle cx="80" cy="58" r="44" fill="#ddb7a8" />
                <path d="M28 102c8-24 34-36 58-36s48 12 58 34l18 148H0Z" fill="url(#bodyRight)" />
                <rect x="-2" y="122" width="38" height="138" rx="19" fill="#ead8d2" transform="rotate(8 -2 122)" />
                <rect x="128" y="122" width="38" height="138" rx="19" fill="#ead8d2" transform="rotate(-10 128 122)" />
                <rect x="34" y="244" width="42" height="164" rx="18" fill="#5978a6" transform="rotate(2 34 244)" />
                <rect x="100" y="242" width="44" height="168" rx="18" fill="#5978a6" transform="rotate(-4 100 242)" />
                <rect x="28" y="398" width="54" height="24" rx="12" fill="#ffffff" />
                <rect x="96" y="402" width="54" height="24" rx="12" fill="#ffffff" />
              </g>

              <g transform="translate(250 192)">
                <circle cx="68" cy="54" r="34" fill="#e2bcae" />
                <path d="M34 90c8-16 22-24 36-24 18 0 32 10 40 28l10 106H12Z" fill="#ead6cf" />
                <rect x="-22" y="112" width="28" height="98" rx="14" fill="#ead6cf" transform="rotate(18 -22 112)" />
                <rect x="126" y="112" width="28" height="98" rx="14" fill="#ead6cf" transform="rotate(-18 126 112)" />
                <rect x="40" y="176" width="28" height="118" rx="14" fill="#6d8cb7" />
                <rect x="78" y="176" width="28" height="118" rx="14" fill="#6d8cb7" />
                <rect x="34" y="288" width="38" height="18" rx="9" fill="#ffffff" />
                <rect x="74" y="288" width="38" height="18" rx="9" fill="#ffffff" />
              </g>

              <path d="M248 298c-20-34-34-48-56-54" stroke="#eadbd4" stroke-width="18" stroke-linecap="round" fill="none" />
              <path d="M390 298c20-34 38-50 62-58" stroke="#eedcd4" stroke-width="18" stroke-linecap="round" fill="none" />
            </svg>
          </div>
        </div>
      </section>

      <section class="den-home__feature-band" aria-label="Hlavné body podujatia">
        @foreach ($highlights as $item)
          <article class="den-home__feature-card">
            <p class="den-home__feature-number">{{ $item['number'] }}</p>
            <h2 class="den-home__feature-title">{{ $item['title'] }}</h2>
            <p class="den-home__feature-text">{{ $item['text'] }}</p>
          </article>
        @endforeach
      </section>

      <section class="den-home__about" aria-labelledby="about-title">
        <div class="den-home__about-visual" aria-hidden="true">
          <div class="den-home__about-illustration">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>

        <div class="den-home__about-copy">
          <p class="den-home__section-kicker">O podujatí</p>
          <h2 id="about-title">Čo vás čaká v Parku pod hradom</h2>
          <p class="den-home__section-text">
            Deň rodiny je pohodové stretnutie, ktoré stavia na jednoduchom princípe: stretnúť sa,
            spomaliť a stráviť čas spolu. Program je navrhnutý tak, aby bol prístupný pre rodiny s deťmi,
            starých rodičov aj priateľov.
          </p>

          <div class="den-home__metrics">
            @foreach ($bars as $bar)
              <article class="den-home__metric">
                <div class="den-home__metric-head">
                  <h3>{{ $bar['label'] }}</h3>
                  <span>{{ $bar['value'] }}%</span>
                </div>
                <div class="den-home__metric-track" aria-hidden="true">
                  <span style="width: {{ $bar['value'] }}%"></span>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </section>

      <section class="den-home__cards" id="program" aria-labelledby="cards-title">
        <div class="den-home__section-heading">
          <p class="den-home__section-kicker">Programové bloky</p>
          <h2 id="cards-title">Čo môžete počas dňa zažiť</h2>
        </div>

        <div class="den-home__cards-grid">
          @foreach ($cards as $index => $card)
            <article class="den-home__info-card {{ $index === 1 ? 'den-home__info-card--accent' : '' }}">
              <h3>{{ $card['title'] }}</h3>
              <p>{{ $card['text'] }}</p>
            </article>
          @endforeach
        </div>
      </section>

      @while(have_posts()) @php(the_post())
        @if (trim(strip_tags(get_the_content())))
          <section class="den-home__content" aria-labelledby="info-title">
            <div class="den-home__section-heading">
              <p class="den-home__section-kicker">Viac informácií</p>
              <h2 id="info-title">Detaily pre návštevníkov</h2>
            </div>

            <div class="den-home__content-copy">
              @includeFirst(['partials.content-page', 'partials.content'])
            </div>
          </section>
        @endif
      @endwhile

      <section class="den-home__schedule" aria-labelledby="schedule-title">
        <div class="den-home__schedule-main">
          <p class="den-home__section-kicker">Harmonogram</p>
          <h2 id="schedule-title">Program dňa</h2>
          <p class="den-home__section-text">
            Program je poskladaný tak, aby mal prirodzený rytmus. Môžete prísť na konkrétny blok
            alebo zostať s nami až do konca.
          </p>
          <a class="den-home__button den-home__button--primary" href="#partneri">Stať sa partnerom</a>
        </div>

        <div class="den-home__schedule-list">
          @foreach ($schedule as $item)
            <article class="den-home__schedule-item">
              <p class="den-home__schedule-time">{{ $item['time'] }}</p>
              <div>
                <h3>{{ $item['title'] }}</h3>
                <p>{{ $item['text'] }}</p>
              </div>
            </article>
          @endforeach
        </div>
      </section>

      <section class="den-home__partners" id="partneri" aria-labelledby="partneri-title">
        <div class="den-home__section-heading">
          <p class="den-home__section-kicker">Partneri</p>
          <h2 id="partneri-title">Priestor pre partnerov a značky</h2>
          <p class="den-home__section-text">
            Po dodaní reálnych log pridám finálny partnerský grid a doladím veľkosti, rozostupy aj varianty.
          </p>
        </div>

        <div class="den-home__partners-grid">
          @foreach ($partners as $partner)
            <div class="den-home__partner">{{ $partner }}</div>
          @endforeach
        </div>
      </section>
    </div>
  </section>
@endsection
