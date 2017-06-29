@extends('layouts.app')

@section('content')
    <h4>登録完了</h4>

    <ul>
        <li><a href="{{ url('game/request') }}">リクエスト一覧へ</a></li>
        <li><a href="{{ url('game/request/input') }}">リクエスト入力へ</a></li>
        <li><a href="{{ url('game/soft') }}">ソフト一覧へ</a></li>
    </ul>
@endsection