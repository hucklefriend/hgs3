@extends('layouts.app')

@section('content')
    <h4>{{ $gameSeries->name }}シリーズ</h4>


    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ url('game/series/edit/') }}/{{ $gameSeries->id }}">データ編集</a>
    </div>
    @endif

    <hr>

    <ul class="list-group">
    @foreach ($games as $game)
        <li class="list-group-item">
            <a href="{{ url('game/soft') }}/{{ $game->id }}">{{ $game->name }}</a>
        </li>
    @endforeach
    </ul>
@endsection