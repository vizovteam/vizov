@extends('layout')

@section('content')
    <div class="row">
      <div class="col-md-6 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <h3 class="text-center">Отправка ссылки на email для потдверждение регистрации</h3>
            @include('partials.alerts')

            <form method="POST" action="/auth/repeat_confirm">
              {!! csrf_field() !!}
              <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Отправить</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection