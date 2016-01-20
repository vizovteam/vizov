@extends('layout')

@section('title_description', $profile->user->name)

@section('meta_description', $profile->user->about)

@section('content')
      <div class="row">
        <div class="col-md-3">
          @include('partials.profile_avatar')
        </div>
        <div class="col-md-9">
          <div class="row-left">
            <div class="panel panel-default">
              <div class="panel-body">
                @include('partials.alerts')
                <h3>{{ $profile->user->name }}</h3>

                <ul class="nav nav-tabs">
                  <li class="@if (old('id')) NULL @else active @endif"><a href="#info" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Профиль</a></li>
                  <li><a href="#posts" data-toggle="tab"><i class="glyphicon glyphicon-list"></i> Объявления</a></li>
                  <li class="@if (old('id')) active @endif"><a href="#reviews" data-toggle="tab"><i class="glyphicon glyphicon-comment"></i> Отзывы</a></li>
                </ul><br>

                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade @if (old('id')) NULL @else active in @endif" id="info">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <tbody>
                          <tr>
                            <td style="width:180px">ФИО</td>
                            <td>{{ $profile->user->name }}</td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td>{{ $profile->user->email }}</td>
                          </tr>
                          <tr>
                            <td>Cфера деятельности</td>
                            <th>{{ ($profile->category_id == 0) ? 'Не указан' : $profile->category->title }}</th>
                          </tr>
                          <tr>
                            <td>Город</td>
                            <td>{{ ($profile->city_id == 0) ? 'Не указан' : $profile->city->title }}</td>
                          </tr>
                          <tr>
                            <td>Адрес работы</td>
                            <td>{{ $profile->address }}</td>
                          </tr>
                          <tr>
                            <td>Навыки</td>
                            <td>{{ $profile->skills }}</td>
                          </tr>
                          <tr>
                            <td>Телефон 1</td>
                            <td>
                              {{ $contacts->phone }}
                              @if ($contacts->telegram == 'on') Telegram, @endif
                              @if ($contacts->whatsapp == 'on') WhatsApp, @endif
                              @if ($contacts->viber == 'on') Viber @endif
                            </td>
                          </tr>
                          <tr>
                            <td>Телефон 2</td>
                            <td>
                              {{ $contacts->phone2 }}
                              @if ($contacts->telegram2 == 'on') Telegram, @endif
                              @if ($contacts->whatsapp2 == 'on') WhatsApp, @endif
                              @if ($contacts->viber2 == 'on') Viber @endif
                            </td>
                          </tr>
                          <tr>
                            <td>Веб-сайт</td>
                            <td>{{ $profile->website }}</td>
                          </tr>
                          <tr>
                            <td>Рейтинг</td>
                            <td>
                              @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $profile->stars)
                                  <i class="glyphicon glyphicon-star text-success"></i>
                                @else
                                  <i class="glyphicon glyphicon-star text-muted"></i>
                                @endif
                              @endfor
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="posts">
                    @forelse ($posts as $post)
                      <div class="media">
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
                            <h4 class="col-md-8 media-heading">
                              <a href="{{ url($post->category->section->service_id.'/'.$post->slug.'/'.$post->id) }}">{{ $post->title }}</a>
                            </h4>
                            <h4 class="col-md-4 media-heading text-right text-success">{{ $post->price }} тг @if ($post->deal == 'on') <br><small>Торг&nbsp;возможен</small> @endif</h4>
                          </div>
                          <p class="text-gray">
                            {{ $post->city->title }} / {{ $post->category->title }}<br>
                            <small>{{ $post->created_at }} &nbsp; Просмотров: {{ $post->views }} &nbsp; <small><i class="glyphicon glyphicon-pencil"></i></small> {{ $post->comments->count() }}</small>
                          </p>
                        </div>
                      </div><hr>
                    @empty
                      <h4>Нет объявлений.</h4>
                    @endforelse
                  </div>
                  <div class="tab-pane fade @if (old('id')) active in @endif" id="reviews">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <i class="glyphicon glyphicon-comment"></i> Отзывов: {{ $profile->comments->count() }}
                      </div>
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            @foreach ($profile->comments as $comment)
                              <tr>
                                <th style="width:110px">{{ $comment->name }}</th>
                                <td>
                                  {{ $comment->comment }}<br>
                                  Оценка:
                                  <span>
                                    @for ($i = 1; $i <= 5; $i++)
                                      @if ($i <= $comment->stars)
                                        <i class="glyphicon glyphicon-star text-success"></i>
                                      @else
                                        <i class="glyphicon glyphicon-star text-muted"></i>
                                      @endif
                                    @endfor
                                  </span><br>
                                  <small class="text-muted">{{ $comment->created_at }}</small>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>

                    @if ($profile->user_id != Auth::id())
                      <div class="well">
                        <h4>Добавить отзыв</h4><br>
                        <form action="/review" method="POST" class="form-horizontal">
                          <input name="_token" type="hidden" value="{{ csrf_token() }}">
                          <input name="id" type="hidden" value="{{ $profile->id }}">
                          <input name="type" type="hidden" value="profile">
                          <input name="type_1" type="hidden" value="profile_{{ $first_number }}">
                          <input name="type_2" type="hidden" value="profile_{{ $second_number }}">
                          <div class="form-group">
                            <label for="name" class="col-md-2">Ваше имя</label>
                            <div class="col-md-10">
                              <input type="text" class="form-control input-sm" id="name" name="name" minlength="3" maxlength="60" placeholder="Введите имя" value="{{ old('name') }}" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="email" class="col-md-2">Email адрес</label>
                            <div class="col-md-10">
                              <input type="email" class="form-control input-sm" id="email" name="email" minlength="8" maxlength="60" placeholder="Введите email" value="{{ old('email') }}" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="comment" class="col-md-2">Сообщение</label>
                            <div class="col-md-10">
                              <textarea rows="3" class="form-control" id="comment" name="comment" maxlength="2000" required>{{ old('comment') }}</textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="comment" class="col-md-2">Оценка услуги</label>
                            <div class="col-md-10">
                              <label>
                                <input type="radio" name="stars" value="1">
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                              </label><br>
                              <label>
                                <input type="radio" name="stars" value="2">
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                              </label><br>
                              <label>
                                <input type="radio" name="stars" value="3">
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                              </label><br>
                              <label>
                                <input type="radio" name="stars" value="4">
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-muted"></i>
                              </label><br>
                              <label>
                                <input type="radio" name="stars" value="5">
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                                <i class="glyphicon glyphicon-star text-success"></i>
                              </label>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-offset-2 col-md-3">
                              <table>
                                <tbody>
                                  <tr>
                                    <th class="text-nowrap">{{ $second_number }} + {{ $first_number }} =&nbsp;</th>
                                    <td><input type="text" class="form-control input-sm" id="equal" name="equal" minlength="1" maxlength="2" placeholder="?" required></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                              <button type="submit" class="btn btn-default btn-sm">Добавить</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
