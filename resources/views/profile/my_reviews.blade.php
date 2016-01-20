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
                <h3>Мой отзывы</h3>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody>
                      @foreach ($profile->comments as $comment)
                        <tr>
                          <td style="width:110px">{{ $comment->name }}</td>
                          <td>
                            <small class="text-muted">{{ $comment->created_at }}</small><br>
                            {{ $comment->comment }}<br>
                            Оценка:
                            <span>
                              @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $comment->stars)
                                  <i class="glyphicon glyphicon-star text-success"></i>
                                @else
                                  <i class="glyphicon glyphicon-star text-muted"></i>
                                @endif
                              @endfor
                            </span>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
