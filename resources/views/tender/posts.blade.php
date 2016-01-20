@extends('layout')

@section('title_description', $category->title_description)

@section('meta_description', $category->meta_description)

@section('content')
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-body">
              <ol class="breadcrumb">
                <li><a href="{{ route($category->section->service->route) }}">{{ $category->section->service->title }}</a></li>
                <li class="active">{{ $category->title }}</li>
              </ol>
              <form action="/filter/posts">
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <table class="table-condensed">
                  <thead>
                    <tr>
                      <td>
                        <select class="form-control input-sm" name="city_id">
                          @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->title }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td style="width:200px;">
                        <select class="form-control input-sm" name="tags[]">
                          @foreach($category->tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                          @endforeach
                        </select>
                        <!-- <div class="dropdown">
                          <button class="btn btn-sm btn-overflow btn-primary dropdown-toggle" type="button" id="category_tags" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Выберите теги <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="category_tags">
                            @foreach($category->tags as $tag)
                              <li><input type="checkbox" id="{{ $tag->slug }}" name="tags[]" value="{{ $tag->id }}"><label for="{{ $tag->slug }}">{{ $tag->title }}</label></li>
                            @endforeach
                          </ul>
                        </div> -->
                      </td>
                      <td>
                        <input type="text" class="form-control input-sm" name="text" placeholder="Поиск по тексту" value="{{ (Request::input('text')) ? Request::input('text') : NULL }}">
                      </td>
                      <td>
                        <div class="checkbox">
                          <label class="text-nowrap">
                            <input type="checkbox" name="image"> с фото
                          </label>
                        </div>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-default btn-block btn-sm">Показать</button>
                      </td>
                    </tr>
                    <!-- <tr>
                      <td>
                        <div class="input-group input-group-sm">
                          <input type="text" class="form-control" name="from" placeholder="Цена от">
                        </div>
                      </td>
                      <td>
                        <div class="input-group input-group-sm">
                          <input type="text" class="form-control" name="to" placeholder="до">
                          <div class="input-group-addon">тг</div>
                        </div>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-primary btn-block btn-sm">Показать</button>
                      </td>
                    </tr> -->
                  </thead>
                </table>
              </form><br>
              @forelse ($posts as $post)
                <section class="media">
                  <div class="media-left">
                    <a href="{{ url($category->section->service_id.'/'.$post->slug.'/'.$post->id) }}">
                      @if ( ! empty($post->image))
                        <img class="media-object" src="/img/posts/{{ $post->user_id.'/'.$post->image }}" alt="{{ $post->title }}" style="width:200px;">
                      @else
                        <img class="media-object" src="/img/no-main-image.png" alt="{{ $post->title }}" style="width:200px;">
                      @endif
                    </a>
                  </div>
                  <div class="media-body">
                    <div class="row post-title-fix">
                      <h4 class="col-md-8 col-sm-8 media-heading">
                        <a href="{{ url($category->section->service_id.'/'.$post->slug.'/'.$post->id) }}">{{ $post->title }}</a>
                      </h4>
                      <h4 class="col-md-4 col-sm-4 media-heading text-right text-success">{{ $post->price }} тг @if ($post->deal == 'on') <small>Торг&nbsp;возможен</small> @endif</h4>
                    </div>
                    <p class="text-gray">{{ $post->city->title }}<br><small>{{ $post->created_at }} &nbsp; Просмотров: {{ $post->views }} &nbsp; <small><i class="text-gray glyphicon glyphicon-pencil"></i></small> {{ $post->comments->count() }}</small></p>
                  </div>
                </section><hr>
              @empty
                <h4>В этой рубрике пока нет объявлений.</h4>
                <a href="{{ route('posts.create') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Добавить объявление</a>
              @endforelse

              {!! $posts->render() !!}
            </div>
          </div>
        </div>
        <aside class="col-md-4">
          @include('partials/rating')
        </aside>
      </div>
@endsection

@section('styles')
  <link href="/bower_components/bootstrap/dist/css/dropdowns-enhancement.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/bower_components/bootstrap/dist/js/dropdowns-enhancement.js"></script>
@endsection
