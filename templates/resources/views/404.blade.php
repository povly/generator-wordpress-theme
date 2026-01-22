@extends('layouts.app')


@section('header')
  @include('sections.header')
@endsection

@section('footer')
  @include('sections.footer')
@endsection

@section('content')
  <div class="_404">
    <div class="container">
      <div class="_404__title section__title">
        {!! __('404 ошибка!', '{{TEXT_DOMAIN}}') !!}
      </div>
      <div class="_404__text">
        {!! __('Такой страницы не существует', '{{TEXT_DOMAIN}}') !!}
      </div>

      <a href="/" class="_404__btn p-btn p-btn--white">
        {!! __('Перейти на главную') !!}
      </a>
    </div>
  </div>
@endsection
