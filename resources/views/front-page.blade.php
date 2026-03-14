@extends('layouts.app')

@section('content')
  @php
    $schedule = [
        ['time' => '16.00', 'title' => 'Otvorenie podujatia', 'text' => 'Privítanie rodín, krátke predstavenie programu a otvorenie zóny pre deti.'],
        ['time' => '16.15', 'title' => 'Rodinné hry pre deti', 'text' => 'Stanovištia, drobné úlohy a hravé aktivity, ktoré zvládnu malí aj veľkí.'],
        ['time' => '16.45', 'title' => 'Skákací hrad', 'text' => 'Voľná zábava pre deti a oddychová zóna pre rodičov v tieni parku.'],
        ['time' => '17.15', 'title' => 'Spoločné aktivity pre rodiny', 'text' => 'Tvorivé a pohybové momenty, ktoré prepájajú rodičov, deti aj starých rodičov.'],
        ['time' => '17.45', 'title' => 'Hudba a občerstvenie', 'text' => 'Uvoľnená atmosféra, malé občerstvenie a priestor zostať spolu dlhšie.'],
        ['time' => '18.00', 'title' => 'Ukončenie', 'text' => 'Pokojné zakončenie podujatia a poďakovanie partnerom aj návštevníkom.'],
    ];

    $facts = [
        ['label' => 'Kedy', 'value' => '17. máj'],
        ['label' => 'Kde', 'value' => 'Park pod hradom'],
        ['label' => 'Pre koho', 'value' => 'Rodiny s deťmi'],
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

  <section class="den-home">
    <div class="den-home__inner">
      <header class="den-home__hero" aria-labelledby="den-rodiny-title">
        <div class="den-home__poster">
          <div class="den-home__poster-copy">
            <p class="den-home__eyebrow">Rodinné popoludnie v meste</p>

            <div class="den-home__brand" id="den-rodiny-title" aria-label="Deň rodiny">
              <div class="den-home__brand-row den-home__brand-row--top">
                <span class="den-home__brand-bubble">:D</span>
                <span class="den-home__brand-bubble">E</span>
                <span class="den-home__brand-bubble">Ň</span>
              </div>

              <div class="den-home__brand-row den-home__brand-row--bottom">
                <span class="den-home__brand-bubble">R</span>
                <span class="den-home__brand-bubble den-home__brand-bubble--icon den-home__brand-bubble--headphones">
                  <span class="sr-only">Objatie</span>
                </span>
                <span class="den-home__brand-bubble">:D</span>
                <span class="den-home__brand-bubble">I</span>
                <span class="den-home__brand-bubble">N</span>
                <span class="den-home__brand-bubble den-home__brand-bubble--icon den-home__brand-bubble--smile">
                  <span class="sr-only">Úsmev</span>
                </span>
              </div>
            </div>

            <p class="den-home__claim">Nesme sa navzájom</p>

            <div class="den-home__lead">
              <p>
                Hravé mestské popoludnie pre rodičov, deti aj starých rodičov. Príďte si užiť spoločný
                čas, hudbu, hry a príjemnú atmosféru v parku pod hradom.
              </p>
            </div>

            <div class="den-home__facts" aria-label="Základné informácie">
              @foreach ($facts as $fact)
                <article class="den-home__fact">
                  <p class="den-home__fact-label">{{ $fact['label'] }}</p>
                  <p class="den-home__fact-value">{{ $fact['value'] }}</p>
                </article>
              @endforeach
            </div>

            <div class="den-home__actions">
              <a class="den-home__button den-home__button--primary" href="#program">Pozrieť program</a>
              <a class="den-home__button den-home__button--ghost" href="#partneri">Partneri</a>
            </div>
          </div>

          <div class="den-home__poster-visual">
            <div class="den-home__paper den-home__paper--top">
              <span>17. máj</span>
              <span>Park pod hradom</span>
            </div>

            <div class="den-home__paper den-home__paper--side">
              <span>Rodina</span>
              <span>Hudba</span>
              <span>Hry</span>
            </div>

            <div class="den-home__stage">
              <div class="den-home__sparkle den-home__sparkle--left" aria-hidden="true">
                @for ($i = 0; $i < 5; $i++)
                  <span></span>
                @endfor
              </div>

              <div class="den-home__sparkle den-home__sparkle--right" aria-hidden="true">
                @for ($i = 0; $i < 6; $i++)
                  <span></span>
                @endfor
              </div>

              <div class="den-home__illustration" aria-hidden="true">
                <svg viewBox="0 0 640 540" role="presentation">
                  <defs>
                    <filter id="familyShadow" x="-20%" y="-20%" width="140%" height="140%">
                      <feDropShadow dx="0" dy="28" stdDeviation="28" flood-color="#6fbfd5" flood-opacity=".24" />
                    </filter>
                    <linearGradient id="bodyLeft" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#efe1da" />
                      <stop offset="100%" stop-color="#dfcdc6" />
                    </linearGradient>
                    <linearGradient id="bodyRight" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#f0e1db" />
                      <stop offset="100%" stop-color="#e0cec6" />
                    </linearGradient>
                    <linearGradient id="jeansLeft" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#4f6991" />
                      <stop offset="100%" stop-color="#39537a" />
                    </linearGradient>
                    <linearGradient id="jeansRight" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#5d7aaa" />
                      <stop offset="100%" stop-color="#42618f" />
                    </linearGradient>
                  </defs>

                  <g filter="url(#familyShadow)">
                    <ellipse cx="320" cy="476" rx="190" ry="26" fill="#afdeec" opacity=".9" />
                  </g>

                  <circle cx="320" cy="228" r="174" fill="#edf9fd" />

                  <g transform="translate(78 92)">
                    <circle cx="88" cy="54" r="45" fill="#d8b3a4" />
                    <path d="M40 96c10-20 34-32 58-32s50 11 60 36l10 148H22Z" fill="url(#bodyLeft)" />
                    <rect x="12" y="118" width="38" height="142" rx="19" fill="#e8d8d2" transform="rotate(8 12 118)" />
                    <rect x="126" y="116" width="38" height="140" rx="19" fill="#e8d8d2" transform="rotate(-8 126 116)" />
                    <rect x="36" y="238" width="44" height="170" rx="18" fill="url(#jeansLeft)" transform="rotate(2 36 238)" />
                    <rect x="102" y="236" width="44" height="172" rx="18" fill="url(#jeansLeft)" transform="rotate(-4 102 236)" />
                    <rect x="28" y="400" width="56" height="24" rx="12" fill="#ffffff" />
                    <rect x="96" y="404" width="56" height="24" rx="12" fill="#ffffff" />
                  </g>

                  <g transform="translate(398 86)">
                    <circle cx="80" cy="58" r="44" fill="#ddb7a8" />
                    <path d="M28 102c8-24 34-36 58-36s48 12 58 34l18 148H0Z" fill="url(#bodyRight)" />
                    <rect x="-2" y="122" width="38" height="138" rx="19" fill="#ead8d2" transform="rotate(8 -2 122)" />
                    <rect x="128" y="122" width="38" height="138" rx="19" fill="#ead8d2" transform="rotate(-10 128 122)" />
                    <rect x="34" y="244" width="42" height="164" rx="18" fill="url(#jeansRight)" transform="rotate(2 34 244)" />
                    <rect x="100" y="242" width="44" height="168" rx="18" fill="url(#jeansRight)" transform="rotate(-4 100 242)" />
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

                  <path d="M248 298c-20-34-34-48-56-54" stroke="#e9d9d2" stroke-width="18" stroke-linecap="round" fill="none" />
                  <path d="M390 298c20-34 38-50 62-58" stroke="#eddad4" stroke-width="18" stroke-linecap="round" fill="none" />
                </svg>
              </div>

              <aside class="den-home__badge">
                <p class="den-home__badge-date">17. máj</p>
                <p class="den-home__badge-divider" aria-hidden="true">......</p>
                <p class="den-home__badge-place">Park pod hradom</p>
              </aside>
            </div>
          </div>
        </div>
      </header>

      <section class="den-home__program" id="program" aria-labelledby="program-title">
        <div class="den-home__section-heading den-home__section-heading--split">
          <div>
            <p class="den-home__section-kicker">Program dňa</p>
            <h2 id="program-title">Čo sa bude diať</h2>
          </div>

          <p class="den-home__section-note">
            Plynulý program bez zbytočného stresu. Dá sa prísť na hodinu aj zostať celé popoludnie.
          </p>
        </div>

        <div class="den-home__timeline">
          @foreach ($schedule as $item)
            <article class="den-home__timeline-item">
              <p class="den-home__timeline-time">{{ $item['time'] }}</p>
              <div class="den-home__timeline-card">
                <h3 class="den-home__timeline-title">{{ $item['title'] }}</h3>
                <p class="den-home__timeline-text">{{ $item['text'] }}</p>
              </div>
            </article>
          @endforeach
        </div>
      </section>

      @while(have_posts()) @php(the_post())
        @if (trim(strip_tags(get_the_content())))
          <section class="den-home__content">
            <div class="den-home__section-heading den-home__section-heading--split">
              <div>
                <p class="den-home__section-kicker">Viac informácií</p>
                <h2>Detaily pre návštevníkov</h2>
              </div>
            </div>

            <div class="den-home__content-copy">
              @includeFirst(['partials.content-page', 'partials.content'])
            </div>
          </section>
        @endif
      @endwhile

      <section class="den-home__partners" id="partneri" aria-labelledby="partneri-title">
        <div class="den-home__section-heading den-home__section-heading--split">
          <div>
            <p class="den-home__section-kicker">Partneri</p>
            <h2 id="partneri-title">Priestor pre partnerov a značky</h2>
          </div>

          <p class="den-home__section-note">
            Keď pošleš reálne logá, nahradím placeholdery a dorovnám im rytmus aj veľkosti.
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
