@extends('layout')

@section('content')
      @include('partials.admin_menu')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-8">
              <h3>Редактирование</h3>
              <form action="{{ route('admin.users.update', $profile->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                {!! csrf_field() !!}
                <div class="form-group">
                  <label for="sort_id" class="col-md-3">Номер</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ $profile->sort_id }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-md-3">Email:</label>
                  <div class="col-md-9">
                    <input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="60" value="{{ $profile->user->email }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-md-3">ФИО:</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="name" minlength="3" maxlength="60" value="{{ $profile->user->name }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone" class="col-md-3">Сфере работы:</label>
                  <div class="col-md-9">
                    <select class="form-control" name="category_id" id="category">
                      @foreach ($section as $item)
                        <optgroup label="{{ $item->title }}">
                          @foreach ($item->categories as $category)
                            @if ($category->id == $profile->category_id)
                              <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                            @else
                              <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endif
                          @endforeach
                        </optgroup>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone" class="col-md-3">Город:</label>
                  <div class="col-md-9">
                    <select class="form-control" name="city_id" id="city">
                      @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->title }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="address" class="col-md-3">Адрес работы:</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="address" id="address" maxlength="200" placeholder="Адрес" value="{{ $profile->address }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone" class="col-md-3">Контакты (телефон):</label>
                  <div class="col-md-9">
                    <input type="tel" class="form-control" name="phone" id="phone" maxlength="40" placeholder="Номер телефона" value="{{ $profile->phone }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="skills" class="col-md-3">Навыки:</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="skills" id="skills" placeholder="Какими навыками вы владете" value="{{ $profile->skills }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="website" class="col-md-3">Веб-сайт:</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="website" id="website" placeholder="Веб-сайт" maxlength="80" value="{{ $profile->website }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="website" class="col-md-3">Аватар:</label>
                  <div class="col-md-9">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                        @if(empty($profile->avatar))
                          <img src="/img/no-avatar.png">
                        @else
                          <img src="/img/users/{{ $profile->user->id . '/' . $profile->avatar }}">
                        @endif
                      </div>
                      <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                      <div>
                        <span class="btn btn-default btn-sm btn-file">
                          <span class="fileinput-new">Выберите картинку</span>
                          <span class="fileinput-exists">Изменить</span><input type="file" name="avatar" accept="image/*">
                        </span>
                        <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput">Удалить</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="stars" class="col-md-3">Рейтинг:</label>
                  <div class="col-md-9">
                    <label>
                      <input type="radio" name="stars" value="1" @if ($profile->stars == 1) checked @endif>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                    </label><br>
                    <label>
                      <input type="radio" name="stars" value="2" @if ($profile->stars == 2) checked @endif>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                    </label><br>
                    <label>
                      <input type="radio" name="stars" value="3" @if ($profile->stars == 3) checked @endif>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                    </label><br>
                    <label>
                      <input type="radio" name="stars" value="4" @if ($profile->stars == 4) checked @endif>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-muted"></i>
                    </label><br>
                    <label>
                      <input type="radio" name="stars" value="5" @if ($profile->stars == 5) checked @endif>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                      <i class="glyphicon glyphicon-star text-success"></i>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="status" class="col-md-3">Статус:</label>
                  <div class="col-md-9">                    
                    <label><input type="radio" name="status" @if($profile->user->status == 1) checked @endif value="1"> Активен</label>
                    <label><input type="radio" name="status" @if($profile->user->status == 0) checked @endif value="0"> Неактивен</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-save"></span> Сохранить</button>
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
@endsection
