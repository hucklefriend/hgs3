@extends('layouts.app')

@section('content')

    <h3>管理メニュー</h3>

    <ul class="list-group">
        <li class="list-group-item">会社マスター</li>
        <li class="list-group-item"><a href="{{ url2('game/soft/add') }}">ゲームソフト登録</a></li>
    </ul>

@endsection