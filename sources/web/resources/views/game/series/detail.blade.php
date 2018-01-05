@extends('layouts.app')

@section('content')
    <h4>{{ $gameSeries->name }}シリーズ</h4>
    <hr>
    <ul class="list-group">
    @foreach ($gameSofts as $game)
        <li class="list-group-item">
            <a href="{{ url('game/soft') }}/{{ $game->id }}">{{ $game->name }}</a>
        </li>
    @endforeach
    </ul>
@endsection