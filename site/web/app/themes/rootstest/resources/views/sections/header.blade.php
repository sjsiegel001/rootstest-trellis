<header class="sticky top-0 z-50 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur">
  <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
    <a class="flex items-center gap-2 text-base font-semibold text-white" href="{{ home_url('/') }}">
      <span class="text-fuchsia-400">◆</span>
      {!! $siteName !!}
    </a>

    <nav class="flex items-center gap-6 text-sm text-slate-400" aria-label="Primary">
      <a href="#stack" class="transition hover:text-white">Stack</a>
      <a href="https://roots.io/docs/" class="hidden transition hover:text-white sm:inline">Docs</a>
      <a href="https://roots.io"
         class="rounded-lg border border-slate-700 px-3 py-1.5 transition hover:bg-slate-900 hover:text-white">
        roots.io
      </a>
    </nav>
  </div>
</header>
