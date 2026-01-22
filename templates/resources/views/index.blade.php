@extends('layouts.app')

@section('header')
  @include('sections.header')
@endsection

@section('footer')
  @include('sections.footer')
@endsection


@section('content')

  @if (! have_posts())
    <x-alert type="warning">
      {!! __('Sorry, no results were found.', '{{TEXT_DOMAIN}}') !!}
    </x-alert>

  @endif

  @while(have_posts())
    @php(the_post())
    @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])

  @endwhile

  {{--  @include('blocks.soon')--}}

@endsection
