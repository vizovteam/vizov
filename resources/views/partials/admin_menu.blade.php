
        <ul class="nav nav-pills nav-justified">
          <li @if (Request::is('admin/pages', 'admin/pages/*')) class="active" @endif><a href="/admin/pages">Страницы</a></li>
          <li @if (Request::is('admin/services', 'admin/services/*')) class="active" @endif><a href="/admin/services">Сервисы</a></li>
          <li @if (Request::is('admin/section', 'admin/section/*')) class="active" @endif><a href="/admin/section">Рубрики</a></li>
          <li @if (Request::is('admin/categories', 'admin/categories/*')) class="active" @endif><a href="/admin/categories">Категории</a></li>
          <li @if (Request::is('admin/tags', 'admin/tags/*')) class="active" @endif><a href="/admin/tags">Теги</a></li>
          <li @if (Request::is('admin/posts', 'admin/posts/*')) class="active" @endif><a href="/admin/posts">Объявления</a></li>
          <li @if (Request::is('admin/users', 'admin/users/*')) class="active" @endif><a href="/admin/users">Пользователи</a></li>
          <li @if (Request::is('admin/settings', 'admin/settings/*')) class="active" @endif><a href="/admin/settings">Настройки</a></li>
          <li><a href="/auth/logout">Выход</a></li>
        </ul><br>