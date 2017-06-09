@extends('layouts.app')

@section('content')
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url('auth/login') }}">ログイン</a></li>
        <li class="list-group-item"><a href="{{ url('account/create') }}">新規登録</a></li>
        <li class="list-group-item"><a href="{{ url('game') }}">ゲームデータベース</a></li>
        <li class="list-group-item"><a href="{{ url('site') }}">サイト</a></li>
        <li class="list-group-item"><a href="{{ url('review') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ url('community') }}">コミュニティ</a></li>
    </ul>
@endsection