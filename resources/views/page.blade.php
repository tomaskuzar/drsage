@extends('layouts.app')

@section('content')
  <div class="page-shell">
    @while(have_posts()) @php(the_post())
      <article @php(post_class('page-article'))>
        @include('partials.page-header')

        <div class="page-content">
          @includeFirst(['partials.content-page', 'partials.content'])
        </div>
      </article>
    @endwhile
  </div>
@endsection
