@extends('layout')

@section('title_description', $page->title_description)

@section('meta_description', $page->meta_description)

@section('content')
  <div class="panel panel-default">
    <div class="panel-body">
      <h3>{{ $page->title }}</h3>
      <p>{{ $page->text }}</p>
    </div>
  </div>
@endsection