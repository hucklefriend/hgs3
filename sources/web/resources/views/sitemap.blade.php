@extends('layouts.app')

@section('title')サイトマップ | @endsection

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>サイトマップ</h1>

    <ul class="list-group no-border mb-5">
        <li class="list-group-item"><a href="{{ route('トップ') }}">トップページ</a></li>
        <li class="list-group-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
        <li class="list-group-item"><a href="{{ route('ゲーム会社一覧') }}">ゲーム会社一覧</a></li>
        <li class="list-group-item"><a href="{{ route('プラットフォーム一覧') }}">プラットフォーム一覧</a></li>
        <li class="list-group-item"><a href="{{ route('シリーズ一覧') }}">シリーズ一覧</a></li>
        <li class="list-group-item"><a href="{{ route('レビュートップ') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
        <li class="list-group-item"><a href="{{ route('お知らせ') }}">お知らせ</a></li>
        <li class="list-group-item"><a href="{{ route('当サイトについて') }}">当サイトについて</a></li>

        @if (\Illuminate\Support\Facades\Auth::check())
        <li class="list-group-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
        @else
        <li class="list-group-item"><a href="{{ route('ログイン') }}">ログイン</a></li>
        <li class="list-group-item"><a href="{{ route('ユーザー登録') }}">ユーザー登録</a></li>
        <li class="list-group-item"><a href="{{ route('パスワード再設定') }}">パスワードを忘れた</a></li>
        @endif
    </ul>

    <h2>外部サイト</h2>
    <ul class="list-group no-border">
        <li class="list-group-item"><a href="https://github.com/hucklefriend/hgs3" target="_blank">GitHubのリポジトリ</a></li>
    </ul>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイトマップ</li>
        </ol>
    </nav>
@endsection