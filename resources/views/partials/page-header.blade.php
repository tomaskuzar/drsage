<header class="page-header">
  <p class="page-header__eyebrow">Stránka</p>
  <h1 class="page-header__title">{!! $title !!}</h1>

  @if (has_excerpt())
    <p class="page-header__excerpt">{{ get_the_excerpt() }}</p>
  @endif
</header>
