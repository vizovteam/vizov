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
                @include('partials.alerts')
                <h3>Мой профиль</h3>
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <tbody>
                      <tr>
                        <td style="width:180px">Ваше ФИО</td>
                        <td>{{ Auth::user()->name }}</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>{{ Auth::user()->email }}</td>
                      </tr>
                      <tr>
                        <td>Cфера деятельности</td>
                        <td>{{ ($profile->category_id == 0) ? 'Не указан' : $profile->category->title }}</td>
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
                          @if ($contacts->telegram == 'on') <i class="glyphicon glyphicon-ok"></i> Telegram @endif
                          @if ($contacts->whatsapp == 'on') <i class="glyphicon glyphicon-ok"></i> WhatsApp @endif
                          @if ($contacts->viber == 'on') <i class="glyphicon glyphicon-ok"></i> Viber @endif
                        </td>
                      </tr>
                      <tr>
                        <td>Телефон 2</td>
                        <td>
                          {{ $contacts->phone2 }}
                          @if ($contacts->telegram2 == 'on') <i class="glyphicon glyphicon-ok"></i> Telegram @endif
                          @if ($contacts->whatsapp2 == 'on') <i class="glyphicon glyphicon-ok"></i> WhatsApp @endif
                          @if ($contacts->viber2 == 'on') <i class="glyphicon glyphicon-ok"></i> Viber @endif
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
                <p>
                  <a href="/my_profile/edit" class="btn btn-primary">Заполнить профиль</a>
                  <a href="/profile/{{ $profile->id }}" class="btn btn-success">Как видят меня другие?</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
