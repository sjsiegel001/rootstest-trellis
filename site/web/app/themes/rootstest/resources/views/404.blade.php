@extends('layouts.app')

@section('content')
  <div class="mx-auto flex min-h-[60vh] max-w-2xl flex-col items-center justify-center px-6 py-24 text-center">
    <p class="bg-gradient-to-r from-fuchsia-400 via-indigo-400 to-cyan-300 bg-clip-text text-7xl font-bold tracking-tight text-transparent sm:text-8xl">
      404
    </p>

    <h1 class="mt-4 text-3xl font-semibold tracking-tight text-white sm:text-4xl">
      {!! __('This page went missing', 'sage') !!}
    </h1>

    <p class="mt-4 text-lg leading-relaxed text-slate-400">
      {!! __("The page you’re looking for doesn’t exist or may have moved. Try one of these instead, or search below.", 'sage') !!}
    </p>

    <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
      <a href="{{ home_url('/') }}"
         class="rounded-lg bg-white px-5 py-3 text-sm font-medium text-slate-900 transition hover:bg-slate-200">
        {!! __('Home', 'sage') !!}
      </a>

      @if ($blog = get_option('page_for_posts'))
        <a href="{{ get_permalink($blog) }}"
           class="rounded-lg border border-slate-700 px-5 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-500 hover:bg-slate-900">
          {!! __('Blog', 'sage') !!}
        </a>
      @endif

      @if ($contact = get_page_by_path('contact'))
        <a href="{{ get_permalink($contact) }}"
           class="rounded-lg border border-slate-700 px-5 py-3 text-sm font-medium text-slate-200 transition hover:border-slate-500 hover:bg-slate-900">
          {!! __('Contact', 'sage') !!}
        </a>
      @endif
    </div>

    <div class="mt-10 w-full max-w-sm">
      {!! get_search_form(['echo' => false]) !!}
    </div>
  </div>
@endsection
