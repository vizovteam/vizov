@extends('layout')

@section('content')
      <div class="row">
        <div class="col-md-3">
          @include('partials.profile_menu')
        </div>
        <div class="col-md-9">
          <div class="row-left">
            <div class="panel panel-default">
              <div class="panel-body">
                <h3>Мои объявления</h3>
                @forelse ($posts as $post)
                  <div class="media">
                    <div class="media-left">
                      <a href="{{ route('show-post-service', ['post' => $post->slug, 'id' => $post->id]) }}">
                        @if ( ! empty($post->image))
                          <img class="media-object" src="/img/posts/{{ $post->user_id.'/'.$post->image }}" alt="{{ $post->title }}" style="width:200px">
                        @else
                          <img class="media-object" src="/img/no-main-image.png" alt="{{ $post->title }}" style="width:200px">
                        @endif
                      </a>
                    </div>
                    <div class="media-body">
                      <div class="row">
                        <div class="col-md-8">
                          <h4 class="media-heading post-title-fix">
                            @include('partials.favorites')
                            <a href="{{ route('show-post-service', ['post' => $post->slug, 'id' => $post->id]) }}">{{ $post->title }}</a>
                          </h4>
                          <p class="text-gray">
                            {{ $post->city->title }} / {{ $post->category->title }}<br>
                            <small>{{ $post->created_at }} &nbsp; Просмотров: {{ $post->views }} &nbsp; <small><i class="glyphicon glyphicon-pencil"></i></small> {{ $post->comments->count() }}</small>
                          </p>
                        </div>
                        <div class="col-md-4">
                          <h4 class="media-heading text-right text-success">{{ $post->price }} тг @if ($post->deal == 'on') <br><small>Торг&nbsp;возможен</small> @endif</h4>
                          <p></p>
                          <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-block btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Редактировать</a>
                          <p></p>
                          <form method="POST" action="{{ route('posts.destroy', $post->id) }}" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-block btn-danger btn-xs" onclick="return confirm('Удалить объявление?')"><span class="glyphicon glyphicon-remove"></span> Удалить</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                @empty
                  <h4>У вас пока нет объявлений.</h4>
                  <a href="{{ route('posts.create') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Добавить объявление</a>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
  <script src="/js/favorite.js"></script>
@endsection

