@extends('layouts.app')

@section('content')
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url('auth/login') }}">ログイン</a></li>
        <li class="list-group-item"><a href="{{ url('account/create') }}">新規登録</a></li>
        <li class="list-group-item"><a href="{{ url('games/list') }}">ゲームデータベース</a></li>
        <li class="list-group-item"><a href="{{ url('sites/list') }}">サイト</a></li>
        <li class="list-group-item"><a href="{{ url('reviews/list') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ url('communities/list') }}">コミュニティ</a></li>
    </ul>

    <hr>
    <h3>以下、仮で認証無し。いずれ正しい場所に移動。</h3>
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ route('master_game_company_list') }}">マスター</a></li>
    </ul>

@endsection