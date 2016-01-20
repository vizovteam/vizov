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
                <h3>Изменение пароля</h3>

                <form method="POST" action="/update_password" role="form">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="password">Старый пароль:</label>
                    <input class="form-control" placeholder="Старый пароль" name="password" id="password" type="password" minlength="6" maxlength="60" required>
                  </div>
                  <div class="form-group">
                    <label for="new_password">Новый пароль:</label>
                    <input class="form-control" placeholder="Новый пароль" name="new_password" id="new_password" type="password" minlength="6" maxlength="60" required>
                  </div>
                  <div class="form-group">
                    <label for="new_password_confirmation">Введите еще раз новый пароль:</label>
                    <input class="form-control" placeholder="Подтвердите новый пароль" name="new_password_confirmation" id="new_password_confirmation" type="password" minlength="6" maxlength="60" required>
                  </div>
                  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-save"></span> Изменить</button>
                </form>
              </div>
            </div>

            <script type="text/javascript">
              window.onload = function () {
                document.getElementById("new_password").onchange = validatePassword;
                document.getElementById("new_password_confirmation").onchange = validatePassword;
              }
              function validatePassword() {
                var pass2 = document.getElementById("new_password_confirmation").value;
                var pass1 = document.getElementById("new_password").value;
                if (pass1 != pass2) {
                  document.getElementById("new_password_confirmation").setCustomValidity("Пароли не совпадают");
                }
                else {
                  document.getElementById("new_password_confirmation").setCustomValidity('');
                  //empty string means no validation error
                }
              }
            </script>
          </div>
        </div>
      </div>
@endsection