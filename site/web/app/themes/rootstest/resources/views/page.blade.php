@extends('layouts.app')

@section('content')
  @while(have_posts())
    @php(the_post())
    <article class="mx-auto max-w-3xl px-6 py-16 sm:py-24">
      @include('partials.page-header')

      <div class="entry-content mt-10">
        @includeFirst(['partials.content-page', 'partials.content'])
      </div>
    </article>
  @endwhile
@endsection
