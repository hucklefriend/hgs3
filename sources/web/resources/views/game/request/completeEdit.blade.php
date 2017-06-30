@extends('layouts.app')

@section('content')
    <p>{{ $game->name }}の編集リクエスト受付</p>

    <ul>
        <li><a href="{{ url('game/request/edit') }}">編集リクエスト一覧へ</a></li>
        <li><a href="{{ url('game/soft') }}">ソフト一覧へ</a></li>
    </ul>
@endsection