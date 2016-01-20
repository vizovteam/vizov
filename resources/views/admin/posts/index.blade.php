@extends('layout')

@section('content')
      @include('partials.admin_menu')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              @include('partials.alerts')
              <div class="table-responsive">
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr class="active">
                      <td>№</td>
                      <td>Рубрика</td>
                      <td>Загаловок</td>
                      <td>Цена</td>
                      <td>Номер</td>
                      <td>Статус</td>
                      <td class="text-right">Функции</td>
                    </tr>
                    <form action="/">
                      <tr>
                        <th style="width: 70px;">
                          <select class="form-control input-sm" name="count">
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                            <option value="all">Все</option>
                          </select>
                        </th>
                        <th>
                          <select class="form-control input-sm" name="category_id" id="category">
                            <option>-</option>
                            @foreach ($section as $item)
                              <optgroup label="{{ $item->title }}">
                                @foreach ($item->categories as $category)
                                  <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                              </optgroup>
                            @endforeach
                          </select>
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="title" placeholder="Загаловок">
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="price" placeholder="Цена">
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="sort_id" placeholder="Номер">
                        </th>
                        <th>
                          <select class="form-control input-sm" name="status">
                            <option>-</option>
                            <option value="1">Активен</option>
                            <option value="0">Неактивен</option>
                          </select>
                        </th>
                        <th class="text-right">
                          <input type="submit" class="btn btn-success btn-sm" value="Показать">
                        </th>
                      </tr>
                    </form>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    @forelse ($posts as $post)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $post->category->title }}</td>
                        <td><a href="{{ url($post->category->section->service_id.'/'.$post->slug.'/'.$post->id) }}" target="_blank">{{ $post->title }}</a></td>
                        <td class="text-nowrap">{{ $post->price }} тг</td>
                        <td>{{ $post->sort_id }}</td>
                        @if ($post->status == 1)
                          <td class="text-success">Активен</td>
                        @else
                          <td class="text-danger">Неактивен</td>
                        @endif
                        <td class="text-right text-nowrap">
                          <a class="btn btn-primary btn-xs" href="{{ url($post->category->section->service_id.'/'.$post->slug.'/'.$post->id) }}" title="Просмотр объявления" target="_blank"><span class="glyphicon glyphicon-file"></span></a>
                          <a class="btn btn-primary btn-xs" href="{{ route('admin.posts.edit', $post->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                          <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" accept-charset="UTF-8" class="btn-delete">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись?')"><span class="glyphicon glyphicon-trash"></span></button>
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

              {!! $posts->render() !!}
            </div>
          </div>
        </div>
      </div>
@endsection
