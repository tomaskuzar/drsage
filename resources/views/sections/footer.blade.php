<footer class="content-info">
  <div class="content-info__inner">
    <div class="content-info__brand">
      <p class="content-info__eyebrow">Deň rodiny</p>
      <p class="content-info__title">{!! $siteName !!}</p>
      @if (! empty($siteDescription))
        <p class="content-info__text">{{ $siteDescription }}</p>
      @endif
    </div>

    <div class="content-info__meta">
      <p class="content-info__text">Rodinné stretnutie, program v parku a priestor pre partnerov.</p>
      <p class="content-info__copyright">© {{ date('Y') }} {!! $siteName !!}</p>
    </div>
  </div>

  @if (! (is_post_type_archive('tribe_events') || is_singular('tribe_events') || (function_exists('tribe_is_event_query') && tribe_is_event_query())))
    @php(dynamic_sidebar('sidebar-footer'))
  @endif
</footer>
