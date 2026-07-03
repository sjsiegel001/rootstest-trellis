@extends('layouts.app')

@section('content')
  <div class="mx-auto max-w-6xl px-6 py-16 sm:py-24">
    <header class="border-b border-slate-800 pb-8">
      <h1 class="text-4xl font-semibold tracking-tight text-white sm:text-5xl">
        {{ get_the_title(get_option('page_for_posts')) ?: __('Blog', 'sage') }}
      </h1>
      <p class="mt-3 max-w-2xl text-lg leading-relaxed text-slate-400">
        Notes on the bespoke bits of rootstest.de — the parts that don't come out of the box. Each post walks through one custom piece of the stack, written as a build note: what the problem was, why the usual approach fell short, and how it was solved.
      </p>
      <p class="mt-4 max-w-2xl leading-relaxed text-slate-500">
        So far that covers the free, Acorn-style block framework for Sage; first-party Umami analytics served through an nginx proxy so privacy blockers don't drop them; transactional email routed through Amazon SES with aligned DKIM and DMARC and no MX record; nightly MySQL backups streamed to S3 with lifecycle tiering; and the Terraform-and-Trellis pipeline that provisions the AWS infrastructure and ships every release with zero downtime. It's all one Bedrock, Trellis, and Sage 11 codebase, reproducible from a single repository.
      </p>
    </header>

    @if (! have_posts())
      <x-alert type="warning">
        {!! __('Nothing here yet.', 'sage') !!}
      </x-alert>
    @endif

    <div class="mt-12 grid gap-6 sm:grid-cols-2">
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
