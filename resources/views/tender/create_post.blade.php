@extends('layout')

@section('content')
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
          <div class="panel-body">
            <h3>Разместить проект</h3><br>
            <form action="{{ route('posts.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="form-group">
                <div class="col-md-offset-3 col-md-9 col-sm-12">
                  @include('partials.alerts')
                </div>

                <label for="title" class="col-md-3 col-sm-3">Название проекта</label>
                <div class="col-md-9 col-sm-9">
                  <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ old('title') }}" placeholder="Кого вы ищете и какую работу нужно выполнить" required>
                </div>
              </div>
              <div class="form-group">
                <label for="price" class="col-md-3 col-sm-3">Подробно опишите задание</label>
                <div class="col-md-9 col-sm-9">
                  <textarea class="form-control" id="description" name="description" rows="6" maxlength="2000" placeholder="Укажите требования к исполнителю и результату, сроки выполнения и другие условия работы">{{ old('description') }}</textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="category" class="col-md-3 col-sm-3">Категории</label>
                <div class="col-md-9 col-sm-9">
                  <select class="form-control" name="category_id" id="category">
                    @foreach ($section as $item)
                      <optgroup label="{{ $item->title }}">
                        @foreach ($item->categories->sortBy('sort_id') as $category)
                          <option value="{{ $category->id }}">{{ $category->title }}</option>                              
                        @endforeach
                      </optgroup>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="tags" class="col-md-3 col-sm-3">Теги</label>
                <div class="col-md-9 col-sm-9">
                  <select class="form-control" name="tag_id" id="tags">
                    @foreach ($section as $item)
                      <optgroup label="{{ $item->title }}">
                        @foreach ($item->categories->sortBy('sort_id') as $tag)
                          <option value="{{ $tag->id }}">{{ $tag->title }}</option>                              
                        @endforeach
                      </optgroup>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="price" class="col-md-3 col-sm-3">Бюджет</label>
                <div class="col-md-5 col-sm-5">
                  <div class="input-group">
                    <input type="text" class="form-control" id="price" name="price" maxlength="10" value="{{ old('price') }}" required>
                    <div class="input-group-addon">тг</div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4">
                  <label class="checkbox-inline">
                    <input type="checkbox" name="deal"> <b>По договоренности</b>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="files" class="col-md-3 col-sm-3">Файлы</label>
                <div class="col-md-9 col-sm-9">
                  <!-- <input type="file" id="files" name="files" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/vnd.oasis.opendocument.text, application/vnd.oasis.opendocument.spreadsheet, application/vnd.oasis.opendocument.presentation, text/plain, application/pdf, image/*"> -->
                  <p><input type="file" id="files" multiple name="files[]" title="Загрузите одну или несколько файлов"></p>
                  <p><input type="file" id="files" multiple name="files[]" title="Загрузите одну или несколько файлов"></p>
                  <p><input type="file" id="files" multiple name="files[]" title="Загрузите одну или несколько файлов"></p>
                </div>
              </div><br>

              <h4>Контактная информация</h4><br>
              <div class="form-group">
                <label for="city" class="col-md-3 col-sm-3">Город</label>
                <div class="col-md-9 col-sm-9">
                  <select class="form-control" name="city_id" id="city">
                    @foreach ($cities as $city)
                      @if ($city->id === $user->profile->city_id)
                        <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
                      @else
                        <option value="{{ $city->id }}">{{ $city->title }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="address" class="col-md-3 col-sm-3">Адрес</label>
                <div class="col-md-9 col-sm-9">
                  <input type="text" class="form-control" id="address" name="address" maxlength="80" value="{{ (old('address')) ? old('address') : '' }}">
                </div>
              </div>
              <div class="form-group">
                <label for="phone" class="col-md-3 col-sm-3">Телефон 1</label>
                <div class="col-md-5 col-sm-5">
                  <input type="tel" class="form-control" id="phone" name="phone" minlength="5" maxlength="40" value="{{ (old('phone')) ? old('phone') : $contacts->phone }}" required>
                </div>
                <div class="col-md-4 col-sm-4 messengers">
                  <label><input type="checkbox" name="telegram" {{ ($contacts->telegram == 'on') ? 'checked' : null }}> Telegram</label>&nbsp;
                  <label><input type="checkbox" name="whatsapp" {{ ($contacts->whatsapp == 'on') ? 'checked' : null }}> WhatsApp</label>&nbsp;
                  <label><input type="checkbox" name="viber" {{ ($contacts->viber == 'on') ? 'checked' : null }}> Viber</label>
                </div>
              </div>
              <div class="form-group">
                <label for="phone" class="col-md-3 col-sm-3">Телефон 2</label>
                <div class="col-md-5 col-sm-5">
                  <input type="tel" class="form-control" id="phone" name="phone2" minlength="5" maxlength="40" value="{{ (old('phone')) ? old('phone') : $contacts->phone2 }}">
                </div>
                <div class="col-md-4 col-sm-4 messengers">
                  <label><input type="checkbox" name="telegram2" {{ ($contacts->telegram2 == 'on') ? 'checked' : null }}> Telegram</label>&nbsp;
                  <label><input type="checkbox" name="whatsapp2" {{ ($contacts->whatsapp2 == 'on') ? 'checked' : null }}> WhatsApp</label>&nbsp;
                  <label><input type="checkbox" name="viber2" {{ ($contacts->viber2 == 'on') ? 'checked' : null }}> Viber</label>
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="col-md-3 col-sm-3">Email</label>
                <div class="col-md-9 col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" maxlength="40" value="{{ (old('email')) ? old('email') : $user->email }}">
                </div>
              </div>
              <div class="form-group">
                <label for="comment" class="col-md-3 col-sm-3">Разрешить комментарии</label>
                <div class="col-md-9 col-sm-9">
                  <select class="form-control" id="comment" name="comment">
                    <option value="all">Всем</option>
                    <option value="nobody">Никому</option>
                    <option value="registered_users">Только зарегистрированным пользователям</option>
                  </select>
                  <br>
                  <p>Размещая объявления на сайте, вы соглашаетесь с <a href="#">этими правилами</a>.</p>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9">
                  <button type="submit" class="btn btn-primary">Разместить объявление</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('styles')
  <link href="/bower_components/jasny-bootstrap/dist/css/fileinput.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/bower_components/jasny-bootstrap/js/fileinput.js"></script>
  <script src="/bower_components/bootstrap-maxlength/src/bootstrap-maxlength.js"></script>
  <script src="/bower_components/bootstrap/dist/js/custom.js"></script>
@endsection