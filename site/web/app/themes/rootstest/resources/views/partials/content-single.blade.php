<article @php(post_class('h-entry mx-auto max-w-3xl px-6 py-16 sm:py-24'))>
  <header class="border-b border-slate-800 pb-8">
    <h1 class="p-name text-4xl font-semibold tracking-tight text-white sm:text-5xl">
      {!! $title !!}
    </h1>

    <div class="mt-4 text-sm text-slate-500">
      @include('partials.entry-meta')
    </div>
  </header>

  @if (has_post_thumbnail())
    {!! get_the_post_thumbnail(null, 'large', [
      'class' => 'mt-8 aspect-[1200/630] w-full rounded-2xl border border-slate-800 object-cover',
      'alt' => get_the_title(),
    ]) !!}
  @endif

  <div class="e-content entry-content mt-10">
    @php(the_content())
  </div>

  @if ($pagination())
    <footer class="mt-10 border-t border-slate-800 pt-8">
      <nav class="page-nav" aria-label="Page">
        {!! $pagination !!}
      </nav>
    </footer>
  @endif

  @php(comments_template())
</article>
