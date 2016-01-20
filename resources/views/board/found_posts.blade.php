@extends('layout')

@section('content')
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-body">
              @if (isset($category))
                <ol class="breadcrumb">
                  <li><a href="{{ route($category->section->service->route) }}">{{ $category->section->service->title }}</a></li>
                  <li class="active">{{ $category->title }}</li>
                </ol>
              @endif
              <div class="well well-modified well-sm">
                <form action="/filter/posts">
                  @if (isset($category))
                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                  @endif
                  <table class="table-condensed">
                    <thead>
                      <tr>
                        <td>
                          <select class="form-control input-sm" name="city_id">
                            <?php 
                              $user_city_id = $user_city->id ? $user_city->id : NULL; // $user_city shared to view in AppServiceProvider
                              $user_city_id = Request::input('city_id') ? Request::input('city_id') : $user_city_id;
                            ?>
                            @foreach($cities as $city)
                              @if ($city->id == $user_city_id)
                                <option value="{{ $city->id }}" selected >{{ $city->title }}</option>
                              @else
                                <option value="{{ $city->id }}">{{ $city->title }}</option>
                              @endif
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <input type="text" class="form-control input-sm" name="text" placeholder="Поиск по тексту" value="{{ (Request::input('text')) ? Request::input('text') : NULL }}">
                        </td>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="image" @if (Request::input('image')) checked @endif> только с фото
                            </label>
                          </div>
                        </td>
                      </tr>
                      @if (isset($category_tags))
                        <tr>
                          <td colspan="2">
                            <div class="form-control input-sm">
                              <select class="" name="tags_id[]" id="category_tags" style="width:100%;" multiple>
                                @foreach( $category_tags as $tag)
                                  <?php
                                    $selected = '';
                                    if ( isset( $selected_tags) ) {
                                      if ( array_search($tag->id, $selected_tags) !== false) {
                                        $selected = 'selected';
                                      }
                                    }
                                  ?>
                                  <option value="{{ $tag->id }}" {{ $selected }} >{{ $tag->title }}</option>
                                @endforeach
                              </select>
                            </div>
                          </td>
                        </tr>
                      @endif
                      <tr>
                        <td>
                          <input type="text" class="form-control input-sm" name="from" placeholder="Цена от" value="{{ (Request::input('from')) ? Request::input('from') : NULL }}">
                        </td>
                        <td>
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="to" placeholder="до" value="{{ (Request::input('to')) ? Request::input('to') : NULL }}">
                            <div class="input-group-addon">тг</div>
                          </div>
                        </td>
                        <td>
                          <button type="submit" class="btn btn-primary btn-block btn-sm">Показать</button>
                        </td>
                      </tr>
                    </thead>
                  </table>
                </form>
              </div>
              <br>

              @forelse ($posts as $post)
                <section class="media">
                  <div class="media-left">
                    <a href="{{ url($post->category->section->service_id.'/'.$post->slug.'/'.$post->id) }}">
                      @if ( ! empty($post->image))
                        <img class="media-object" src="/img/posts/{{ $post->user_id.'/'.$post->image }}" alt="{{ $post->title }}" style="width:200px">
                      @else
                        <img class="media-object" src="/img/no-main-image.png" alt="{{ $post->title }}" style="width:200px">
                      @endif
                    </a>
                  </div>
                  <div class="media-body">
                    <div class="row post-title-fix">
                      <h4 class="col-md-8 col-sm-8 media-heading">
                        @include('partials.favorites')
                        <a href="{{ url($post->category->section->service_id.'/'.$post->slug.'/'.$post->id) }}">{{ $post->title }}</a>
                      </h4>
                      <h4 class="col-md-4 col-sm-4 media-heading text-right text-success">{{ $post->price }} тг @if ($post->deal == 'on') <small>Торг&nbsp;возможен</small> @endif</h4>
                    </div>
                    <p class="text-gray">{{ $post->city->title }} / {{ $post->category->section->title }} <br><small>{{ $post->created_at }} &nbsp; Просмотров: {{ $post->views }} &nbsp; <small><i class="text-gray glyphicon glyphicon-pencil"></i></small> {{ $post->comments->count() }}</small></p>
                  </div>
                </section><hr>
              @empty
                <h4>В этой рубрике пока нет объявлений.</h4>
                <a href="{{ route('posts.create') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Разместить Услугу</a>
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
  <link href="/css/multiple-select.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/multiple-select.js"></script>
  <script src="/js/multi-tag-select.js"></script>
  <script src="/js/favorite.js"></script>
@endsection
