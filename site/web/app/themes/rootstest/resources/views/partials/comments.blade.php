@if (! post_password_required())
  <section id="comments" class="comments">
    @if ($responses())
      <h2 class="text-2xl font-semibold tracking-tight text-white">
        {!! $title !!}
      </h2>

      <ol class="comment-list">
        {!! $responses !!}
      </ol>

      @if ($paginated())
        <nav aria-label="Comment" class="mt-6 text-sm [&_a]:text-fuchsia-300">
          <ul class="flex justify-between">
            @if ($previous())
              <li class="previous">{!! $previous !!}</li>
            @endif

            @if ($next())
              <li class="next">{!! $next !!}</li>
            @endif
          </ul>
        </nav>
      @endif
    @endif

    @if ($closed())
      <x-alert type="warning">
        {!! __('Comments are closed.', 'sage') !!}
      </x-alert>
    @endif

    @php(comment_form())
  </section>
@endif
