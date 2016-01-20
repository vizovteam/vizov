<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title_description', 'Vizov.kz')</title>
    <meta name="description" content="@yield('meta_description', 'Vizov.kz')">

    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap-cosmo.min.css">
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/styles.css">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <link rel="stylesheet" href="/iconfont/material-icons.css">
    @yield('styles')

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <header class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="row">
          <div class="col-md-2 col-sm-3 col-xs-3">
            <a href="{{ route('index') }}" class="logo">
              <img src="/img/vizov.png" class="img-responsive">
            </a>
          </div>
          <div class="col-md-8 col-sm-6 col-xs-5">
            <form action="/search/posts">
              <div class="input-group">
                <input type="text" class="form-control input-sm" name="text" minlength="2" maxlength="100" placeholder="Введите название услуги или товара" required>
                <div class="input-group-btn">
                  <button class="btn btn-default btn-sm" type="submit">
                    <i class="glyphicon glyphicon-search"></i> <span class="hidden-xs">Найти</span>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2 col-sm-3 col-xs-4">
            <div class="btn-group pull-right">
              @if (Auth::guest())
                <a class="btn btn-primary btn-sm" href="/auth/login">Войти</a>
                <a class="btn btn-primary btn-sm" href="/auth/register">Регистрация</a>
              @elseif (Auth::user()->is('user'))
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="glyphicon glyphicon-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="/my_profile"><i class="glyphicon glyphicon-user"></i> Мой профиль</a></li>
                  <li><a href="/my_posts"><i class="glyphicon glyphicon-list-alt"></i> Мои объявления</a></li>
                  <li><a href="{{ route('posts.create') }}"><i class="glyphicon glyphicon-plus"></i> Разместить Услугу</a></li>
                  <li class="divider"></li>
                  <li><a href="/auth/logout"><i class="glyphicon glyphicon-log-out"></i> Выход</a></li>
                </ul>
              @elseif (Auth::user()->is('admin'))
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="glyphicon glyphicon-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="/admin/pages">Страницы</a></li>
                  <li><a href="/admin/services">Сервисы</a></li>
                  <li><a href="/admin/section">Разделы</a></li>
                  <li><a href="/admin/categories">Категории</a></li>
                  <li><a href="/admin/tags">Теги</a></li>
                  <li><a href="/admin/posts">Объявления</a></li>
                  <li><a href="/admin/users">Пользователи</a></li>
                  <li class="divider"></li>
                  <li><a href="/auth/logout">Выход</a></li>
                </ul>
              @endif
            </div>
          </div>
        </div>
      </div>
    </header>

    <nav class="navbar-services">
      <div class="container">
        <div class="row">
          <div class="col-md-offset-2 col-md-6 col-sm-6">
            <a class="btn btn-link btn-sm text-uppercase" href="{{ route('services') }}"><b>Все Услуги</b></a>
          </div>
          <div class="col-md-4 col-sm-6">
            <a class="btn btn-success btn-sm pull-right" href="{{ route('posts.create') }}"><i class="glyphicon glyphicon-plus"></i> Разместить Услугу</a>

            <a class="show-favorite pull-right" href="{{ route('get-favorites') }}"><i class="glyphicon glyphicon-star-empty"></i>
              <sup>
                @if(isset($favorites) && count($favorites))
                  {{ count($favorites) }}
                @endif
              </sup>
            </a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container">
      @yield('content')
    </div><hr>

    <footer class="footer container"><br>
      <div class="row">
        <div class="col-md-8">
          <ul class="list-unstyled list-inline">
            @foreach ($pages as $page)
              <li><a href="{{ url('p/' . $page->slug) }}">{{ $page->title }}</a></li>
            @endforeach
          </ul>
        </div>
        <div class="col-md-4 text-right">
          <p class="text-right">© 2015 — 2016 «VIZOV»</p>
        </div>
      </div><br>
    </footer>

    <!-- // <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <!-- // <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
    <script src="/bower_components/bootstrap/dist/js/jquery-2.1.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    @yield('scripts')
  </body>
</html>