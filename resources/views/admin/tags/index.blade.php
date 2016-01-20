@extends('layout')

@section('content')
      @include('partials.admin_menu')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              @include('partials.alerts')
              <p class="text-right">
                <a href="/admin/tags/create" class="btn btn-success btn-sm">Добавить</a>
              </p>
              <div class="table-responsive">
                <table class="table-admin table table-striped table-condensed">
                  <thead>
                    <tr class="active">
                      <td>№</td>
                      <td>Категория</td>
                      <td>Название</td>
                      <td>Номер</td>
                      <td>Статус</td>
                      <td class="text-right">Функции</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    @forelse ($tags as $n => $tag)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $tag->category->title }}</td>
                        <td>{{ $tag->title }}</td>
                        <td>{{ $tag->sort_id }}</td>
                        @if ($tag->status == 1)
                          <td class="text-success">Активен</td>
                        @else
                          <td class="text-danger">Неактивен</td>
                        @endif
                        <td class="text-right">
                          <a class="btn btn-primary btn-xs" href="{{ route('admin.tags.edit', $tag->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                          <form method="POST" action="{{ route('admin.tags.destroy', $tag->id) }}" accept-charset="UTF-8" class="btn-delete">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $tag->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7">Нет записи</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection