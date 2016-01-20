@extends('layout')

@section('content')
      <div class="row">
        <div class="col-md-6 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-body">
              <h3 class="text-center">Сброс пароля</h3>
              @include('partials.alerts')

              <form method="POST" action="/password/reset">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                  <label for="email" class="control-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" minlength="8" maxlength="60" placeholder="Введите тот же email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                  <label for="password" class="control-label">Пароль</label> (более 6 символов)
                  <input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="60" placeholder="Введите пароль" required>
                </div>
                <div class="form-group">
                  <label for="password_confirmation" class="control-label">Подтвердите Пароль</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="6" maxlength="60" placeholder="Введите еще раз пароль" required>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Сбросить пароль</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <script type="text/javascript">
        window.onload = function () {
          document.getElementById("password").onchange = validatePassword;
          document.getElementById("password_confirmation").onchange = validatePassword;
        }
        function validatePassword() {
          var pass2 = document.getElementById("password_confirmation").value;
          var pass1 = document.getElementById("password").value;
          if (pass1 != pass2)
            document.getElementById("password_confirmation").setCustomValidity("Пароли не совпадают");
          else
            document.getElementById("password_confirmation").setCustomValidity('');
            //empty string means no validation error
        }
      </script>
@endsection