@php
  $eyebrow = $attributes['eyebrow'] ?? '';
  $title = $attributes['title'] ?? '';
  $lead = $attributes['lead'] ?? '';
  $primaryLabel = $attributes['primaryLabel'] ?? '';
  $primaryUrl = $attributes['primaryUrl'] ?? '#';
  $secondaryLabel = $attributes['secondaryLabel'] ?? '';
  $secondaryUrl = $attributes['secondaryUrl'] ?? '#';
@endphp

<section class="relative overflow-hidden">
  <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
    <div class="absolute left-1/2 top-[-15%] h-[520px] w-[900px] max-w-full -translate-x-1/2 rounded-full bg-gradient-to-tr from-fuchsia-600/30 via-indigo-600/20 to-cyan-500/20 blur-3xl"></div>
  </div>

  <div class="mx-auto max-w-5xl px-6 pt-24 pb-12 text-center">
    @if ($eyebrow)
      <span class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-slate-900/60 px-4 py-1.5 text-sm text-slate-400">
        <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
        {{ $eyebrow }}
      </span>
    @endif

    <h1 class="mt-6 bg-gradient-to-r from-fuchsia-400 via-indigo-400 to-cyan-300 bg-clip-text text-5xl font-semibold tracking-tight text-transparent sm:text-6xl">
      {{ $title }}
    </h1>

    @if ($lead)
      <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-slate-400">{{ $lead }}</p>
    @endif

    <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
      @if ($primaryLabel)
        <a href="{{ $primaryUrl }}" class="rounded-lg bg-white px-5 py-3 text-sm font-medium text-slate-900 transition hover:bg-slate-200">{{ $primaryLabel }}</a>
      @endif
      @if ($secondaryLabel)
        <a href="{{ $secondaryUrl }}" class="rounded-lg border border-slate-700 px-5 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-900">{{ $secondaryLabel }}</a>
      @endif
    </div>
  </div>
</section>
