@extends('layouts.app')

@section('content')
  <div class="mx-auto max-w-6xl px-6 py-16 sm:py-24">
    <header class="border-b border-slate-800 pb-8">
      <h1 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">
        {!! __('Search results', 'sage') !!}
      </h1>

      @if (get_search_query())
        <p class="mt-3 text-slate-400">
          {!! sprintf(__('Showing results for <span class="text-slate-200">“%s”</span>', 'sage'), esc_html(get_search_query())) !!}
        </p>
      @endif

      <div class="mt-6 max-w-md">
        {!! get_search_form(['echo' => false]) !!}
      </div>
    </header>

    @if (! have_posts())
      <p class="mt-10 text-slate-400">
        {!! __('Nothing matched your search. Try different or more general keywords.', 'sage') !!}
      </p>
    @endif

    @if (have_posts())
      <div class="mt-12 grid gap-6 sm:grid-cols-2">
        @while(have_posts()) @php(the_post())
          @include('partials.content-search')
        @endwhile
      </div>

      <div class="mt-12 border-t border-slate-800 pt-8 text-sm [&_a]:text-fuchsia-300 [&_a:hover]:text-fuchsia-200">
        {!! get_the_posts_navigation() !!}
      </div>
    @endif
  </div>
@endsection
