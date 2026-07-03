<article @php(post_class('h-entry mx-auto max-w-3xl px-6 py-16 sm:py-24'))>
  <header class="border-b border-slate-800 pb-8">
    <h1 class="p-name text-4xl font-semibold tracking-tight text-white sm:text-5xl">
      {!! $title !!}
    </h1>

    <div class="mt-4 text-sm text-slate-500">
      @include('partials.entry-meta')
    </div>
  </header>

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
