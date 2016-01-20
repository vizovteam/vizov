        <div class="panel panel-default">
          <div class="panel-body">
            @if (empty(Auth::user()->profile->avatar))
              <img src="/img/no-avatar.png" class="img-responsive">
            @else
              <img src="/img/users/{{ Auth::id() . '/' . Auth::user()->profile->avatar }}" class="center-block img-responsive">
            @endif
            <h5 class="text-center">{{ Auth::user()->name }}</h5>
          </div>
          @if (Auth::check())
            <div class="list-group">
              <a href="/my_profile" class="list-group-item @if (Request::is('my_profile')) active @endif">Мой профиль</a>
              <a href="/my_posts" class="list-group-item @if (Request::is('my_posts')) active @endif"><span class="badge">{{ Auth::user()->posts->count() }}</span> Мои объявления</a>
              <a href="/my_reviews" class="list-group-item @if (Request::is('my_reviews')) active @endif">Мои отзывы</a>
              <a href="/my_setting" class="list-group-item @if (Request::is('my_setting')) active @endif">Настройки</a>
              <a href="/auth/logout" class="list-group-item">Выход</a>
            </div>
          @endif
        </div>