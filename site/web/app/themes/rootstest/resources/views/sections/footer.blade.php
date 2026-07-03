<footer class="border-t border-slate-800 bg-slate-950">
  <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-6 py-10 text-sm text-slate-500 sm:flex-row">
    <p>&copy; {{ date('Y') }} {{ get_bloginfo('name') }} &middot; built with the Roots stack</p>

    <div class="flex items-center gap-6">
      @if ($privacy = get_option('wp_page_for_privacy_policy'))
        <a href="{{ get_permalink($privacy) }}" class="transition hover:text-slate-300">Privacy</a>
      @endif
      <span class="flex items-center gap-2">
        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
        Bedrock &middot; Trellis &middot; Sage
      </span>
    </div>
  </div>
</footer>
