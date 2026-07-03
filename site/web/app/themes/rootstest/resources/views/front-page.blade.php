@extends('layouts.app')

@section('content')
  {{-- Hero (structural — lives in the template) --}}
  <section class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
      <div class="absolute left-1/2 top-[-15%] h-[520px] w-[900px] max-w-full -translate-x-1/2 rounded-full bg-gradient-to-tr from-fuchsia-600/30 via-indigo-600/20 to-cyan-500/20 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-5xl px-6 pt-24 pb-16 text-center">
      <span class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-slate-900/60 px-4 py-1.5 text-sm text-slate-400">
        <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
        Live on AWS &middot; deployed with Trellis
      </span>

      <h1 class="mt-6 text-5xl font-semibold tracking-tight text-white sm:text-6xl">
        The
        <span class="bg-gradient-to-r from-fuchsia-400 via-indigo-400 to-cyan-300 bg-clip-text text-transparent">Roots</span>
        stack,<br class="hidden sm:block"> shipped to production.
      </h1>

      <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-slate-400">
        {{ get_bloginfo('name') }} is a WordPress site built on Bedrock, provisioned with Trellis,
        and themed with Sage&nbsp;11. Infrastructure lives in Terraform; media rides a CloudFront CDN.
        This whole page is a Blade template compiled by Vite.
      </p>

      <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
        <a href="https://roots.io" class="rounded-lg bg-white px-5 py-3 text-sm font-medium text-slate-900 transition hover:bg-slate-200">
          Explore Roots
        </a>
        <a href="#stack" class="rounded-lg border border-slate-700 px-5 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-900">
          See the stack &darr;
        </a>
      </div>
    </div>
  </section>

  {{-- Editable page content — the Stack Grid block is managed here, in the editor --}}
  <div class="pb-16">
    @while(have_posts())
      @php(the_post())
      @php(the_content())
    @endwhile
  </div>
@endsection
