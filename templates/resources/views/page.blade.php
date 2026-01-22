@extends('layouts.app')

@section('header')
  @include('sections.header')
@endsection

@section('footer')
  @include('sections.footer')
@endsection

@section('content')
  @if(!is_front_page())
    <div class="container">
      @php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<p class="breadcrumbs">', '</p>');
        }
      @endphp
    </div>
  @endif

  @while (have_posts())
    @php(the_post())
    @includeFirst(['partials.content-page', 'partials.content'])
  @endwhile
@endsection
