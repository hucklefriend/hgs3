@extends('layouts.app')

@section('content')
    <ul class="list-group">
@if ($isLogin)
        <li class="list-group-item"><a href="{{ url('auth/logout') }}">ログアウト</a></li>
@else
        <li class="list-group-item"><a href="{{ url('auth/login') }}">ログイン</a></li>
@endif
        <li class="list-group-item"><a href="{{ url('account/create') }}">新規登録</a></li>
        <li class="list-group-item"><a href="{{ url('game/soft') }}">ゲームデータベース</a></li>
        <li class="list-group-item"><a href="{{ url('site') }}">サイト</a></li>
        <li class="list-group-item"><a href="{{ url('game/review') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ url('community') }}">コミュニティ</a></li>

    </ul>

    @if ($isLogin)
    <hr>
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url('mypage') }}">マイページ</a></li>
    </ul>
    @endif

    @if ($isAdmin)
    <hr>
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url('admin/injustice_review') }}">不正レビュー</a></li>
    </ul>
    @endif
@endsection