@extends('layouts.app')

@section('content')
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url('auth/login') }}">ログイン</a></li>
        <li class="list-group-item"><a href="{{ url('account/create') }}">新規登録</a></li>
        <li class="list-group-item"><a href="{{ url('games/list') }}">ゲームデータベース</a></li>
        <li class="list-group-item"><a href="{{ url('sites/list') }}">サイト</a></li>
        <li class="list-group-item"><a href="{{ url('reviews/list') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ url('communities/list') }}">レビュー</a></li>
    </ul>
@endsection