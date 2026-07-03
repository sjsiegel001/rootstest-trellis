<article @php(post_class('group'))>
  <div class="text-sm text-slate-500">
    @include('partials.entry-meta')
  </div>

  <h2 class="mt-3 text-2xl font-semibold tracking-tight text-white">
    <a href="{{ get_permalink() }}" class="transition hover:text-fuchsia-300">
      {!! $title !!}
    </a>
  </h2>

  <div class="mt-3 leading-relaxed text-slate-400">
    @php(the_excerpt())
  </div>

  <a href="{{ get_permalink() }}"
     class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-fuchsia-300 transition hover:text-fuchsia-200">
    Read more <span aria-hidden="true">&rarr;</span>
  </a>
</article>
