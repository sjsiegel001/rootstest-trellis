<article @php(post_class('flex flex-col rounded-2xl border border-slate-800 bg-slate-900/40 p-6 transition hover:border-slate-600 hover:bg-slate-900'))>
  <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
    {{ get_post_type_object(get_post_type())->labels->singular_name ?? get_post_type() }}
  </p>

  <h2 class="mt-2 text-lg font-semibold text-white">
    <a href="{{ get_permalink() }}" class="transition hover:text-fuchsia-300">
      {!! $title !!}
    </a>
  </h2>

  @if (get_post_type() === 'post')
    <div class="mt-2 text-xs text-slate-500">{{ get_the_date() }}</div>
  @endif

  <div class="mt-3 text-sm leading-relaxed text-slate-400">
    @php(the_excerpt())
  </div>

  <a href="{{ get_permalink() }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-fuchsia-300 transition hover:text-fuchsia-200">
    {!! __('View', 'sage') !!} <span aria-hidden="true">&rarr;</span>
  </a>
</article>
