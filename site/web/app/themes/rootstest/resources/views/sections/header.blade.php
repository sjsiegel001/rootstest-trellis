<header class="sticky top-0 z-50 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur">
  <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
    <a class="flex items-center gap-2 text-base font-semibold text-white" href="{{ home_url('/') }}">
      <span class="text-fuchsia-400">◆</span>
      {!! $siteName !!}
    </a>

    @if (has_nav_menu('primary_navigation'))
      {{-- Desktop nav --}}
      <nav class="hidden md:block" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
        {!! wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'container' => false,
          'menu_class' => 'flex items-center gap-4',
          'echo' => false,
        ]) !!}
      </nav>

      {{-- Mobile toggle --}}
      <button type="button" data-nav-toggle aria-controls="mobile-nav" aria-expanded="false"
        class="inline-flex items-center justify-center rounded-lg border border-slate-700 p-2 text-slate-300 transition hover:bg-slate-900 md:hidden">
        <span class="sr-only">{{ __('Toggle navigation', 'sage') }}</span>
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <line x1="3" y1="6" x2="21" y2="6" />
          <line x1="3" y1="12" x2="21" y2="12" />
          <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
      </button>
    @endif
  </div>

  @if (has_nav_menu('primary_navigation'))
    {{-- Mobile panel --}}
    <nav id="mobile-nav" data-nav-panel hidden class="border-t border-slate-800 md:hidden" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      {!! wp_nav_menu([
        'theme_location' => 'primary_navigation',
        'container' => false,
        'menu_class' => 'flex flex-col gap-1 px-6 py-4',
        'echo' => false,
      ]) !!}
    </nav>
  @endif
</header>
