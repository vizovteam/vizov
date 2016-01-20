@extends('layout')

@section('title_description', $service->title_description)

@section('meta_description', $service->meta_description)

@section('content')

  @foreach ($section as $item)
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <h4 class="category-title text-center" data-toggle="collapse" data-target="#{{ $item->slug }}" aria-expanded="false" aria-controls="{{ $item->slug }}">{{ $item->title }} <span class="caret"></span></h4><br>
      </div>
    </div>
    <div class="collapse in categories" id="{{ $item->slug }}">
      @foreach ($item->categories->sortBy('sort_id')->chunk(4) as $chunk)
        <div class="row">
          <div class="col-md-2"></div>
          @foreach ($chunk as $category)
            <section class="col-md-2 col-sm-3 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="{{ url($category->section->service->slug.'/'.$category->slug) }}">
                    <img src="/img/categories/{{ $category->image }}" alt="{{ $category->title }}">
                    <h5>{{ $category->title }}</h5>
                  </a>
                </div>
              </div>
            </section>
          @endforeach
        </div>
      @endforeach
    </div>
  @endforeach
  
<!--   @foreach ($section as $item)
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <h4 class="category-title text-center" data-toggle="collapse" data-target="#{{ $item->slug }}" aria-expanded="false" aria-controls="{{ $item->slug }}">{{ $item->title }} <span class="caret"></span></h4><br>
      </div>
    </div>
    <div class="collapse in categories" id="{{ $item->slug }}">
      @foreach ($item->categories->sortBy('sort_id')->chunk(4) as $chunk)
        <div class="row">
          <div class="col-md-2"></div>
          @foreach ($chunk as $category)
            <section class="col-md-2 col-sm-3 col-xs-6">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="{{ url($category->section->service->slug.'/'.$category->slug) }}">
                    <img src="/img/categories/{{ $category->image }}" alt="{{ $category->title }}">
                    <h5>{{ $category->title }}</h5>
                  </a>
                </div>
              </div>
            </section>
          @endforeach
        </div>
      @endforeach
    </div>
  @endforeach -->
  @foreach ($categories->sortBy('sort_id')->chunk(4) as $chunk)
    <div class="row categories">
      <div class="col-md-2"></div>
      @foreach ($chunk as $category)
        <section class="col-md-2 col-sm-3 col-xs-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <a href="{{ url($category->section->service->slug.'/'.$category->slug) }}">
                <img src="/img/categories/{{ $category->image }}" alt="{{ $category->title }}">
                <h5>{{ $category->title }}</h5>
              </a>
            </div>
          </div>
        </section>
      @endforeach
    </div>
  @endforeach
@endsection
