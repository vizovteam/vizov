@extends('layout')

@section('title_description', $service->title_description)

@section('meta_description', $service->meta_description)

@section('content')
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      @foreach ($section as $item)
        <h4 class="category-title text-center text-muted" data-toggle="collapse" data-target="#{{ $item->slug }}" aria-expanded="false" aria-controls="{{ $item->slug }}">{{ $item->title }} <span class="caret"></span></h4><br>
        <section class="col-md-12 categories collapse in" id="{{ $item->slug }}"><br>
          @foreach ($item->categories->sortBy('sort_id')->chunk(3) as $chunk)
            <div class="row">
              @foreach ($chunk as $category)
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <a href="{{ url($category->section->service->slug.'/'.$category->slug) }}" class="service">
                    <i class="material-icons md-36 icon">{{ $category->image }}</i> <span class="title">{{ $category->title }}</span>
                  </a>
                </div>
              @endforeach
            </div><br>
          @endforeach
        </section>
      @endforeach
    </div>
  </div>
@endsection