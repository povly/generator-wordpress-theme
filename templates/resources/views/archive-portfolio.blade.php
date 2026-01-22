@extends('layouts.app')

@section('header')
  @include('sections.header')
@endsection

@section('footer')
  @include('sections.footer')
@endsection


@section('content')
  @include('includes.archive.portfolio_category')
@endsection
