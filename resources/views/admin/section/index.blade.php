@extends('layout')

@section('content')
      @include('partials.admin_menu')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              @include('partials.alerts')
              <p class="text-right">
                <a href="/admin/section/create" class="btn btn-success btn-sm">Добавить</a>
              </p>
              <div class="table-responsive">
                <table class="table-admin table table-striped table-condensed">
                  <thead>
                    <tr class="active">
                      <td>№</td>
                      <td>Сервис</td>
                      <td>Название</td>
                      <td>Номер</td>
                      <td>Статус</td>
                      <td class="text-right">Функции</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    @forelse ($section as $item)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->service->title }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->sort_id }}</td>
                        @if ($item->status == 1)
                          <td class="text-success">Активен</td>
                        @else
                          <td class="text-danger">Неактивен</td>
                        @endif
                        <td class="text-right">
                          <a class="btn btn-primary btn-xs" href="{{ route('admin.section.edit', $item->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                          <form method="POST" action="{{ route('admin.section.destroy', $item->id) }}" accept-charset="UTF-8" class="btn-delete">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $item->title }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4">Нет записи</td>
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