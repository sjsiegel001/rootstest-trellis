@extends('layouts.app')

@section('content')
  <div class="mx-auto max-w-3xl px-6 py-16 sm:py-24">
    <header class="border-b border-slate-800 pb-8">
      <h1 class="text-4xl font-semibold tracking-tight text-white sm:text-5xl">
        {{ get_the_title(get_option('page_for_posts')) ?: __('Blog', 'sage') }}
      </h1>
      <p class="mt-3 text-lg leading-relaxed text-slate-400">
        Notes on the bespoke bits — the block framework, first-party analytics, transactional mail, nightly backups, and more.
      </p>
    </header>

    @if (! have_posts())
      <x-alert type="warning">
        {!! __('Nothing here yet.', 'sage') !!}
      </x-alert>
    @endif

    <div class="mt-12 space-y-12">
      @while(have_posts())
        @php(the_post())
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
      @endwhile
    </div>

    <div class="mt-12 border-t border-slate-800 pt-8 text-sm [&_a:hover]:text-fuchsia-200 [&_a]:text-fuchsia-300">
      {!! get_the_posts_navigation([
        'prev_text' => '&larr; Older posts',
        'next_text' => 'Newer posts &rarr;',
      ]) !!}
    </div>
  </div>
@endsection
