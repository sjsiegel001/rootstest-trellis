<article @php(post_class('group flex flex-col overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/40 transition duration-200 hover:-translate-y-1 hover:border-slate-600 hover:bg-slate-900'))>
  @if (has_post_thumbnail())
    <a href="{{ get_permalink() }}" class="block overflow-hidden">
      {!! get_the_post_thumbnail(null, 'large', [
        'class' => 'aspect-[1200/630] w-full object-cover transition duration-300 group-hover:scale-[1.02]',
        'loading' => 'lazy',
        'alt' => get_the_title(),
      ]) !!}
    </a>
  @endif

  <div class="flex flex-1 flex-col p-6">
    <div class="text-sm text-slate-500">
      @include('partials.entry-meta')
    </div>

    <h2 class="mt-2 text-xl font-semibold tracking-tight text-white">
      <a href="{{ get_permalink() }}" class="transition hover:text-fuchsia-300">
        {!! $title !!}
      </a>
    </h2>

    <div class="mt-3 flex-1 text-sm leading-relaxed text-slate-400">
      @php(the_excerpt())
    </div>

    <a href="{{ get_permalink() }}"
       class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-fuchsia-300 transition hover:text-fuchsia-200">
      Read more <span aria-hidden="true">&rarr;</span>
    </a>
  </div>
</article>
