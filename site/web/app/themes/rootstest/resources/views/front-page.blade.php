@extends('layouts.app')

{{--
  The homepage is composed entirely of blocks edited on the "Home" page:
  the Hero block and the Stack Grid block. The template just renders that content.
--}}
@section('content')
  @while(have_posts())
    @php(the_post())
    @php(the_content())
  @endwhile
@endsection
