@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')
    <h1>サイトマップ</h1>

    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url2('') }}">トップページ</a></li>
        <li class="list-group-item"><a href="{{ url2('game/soft') }}">ゲーム一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('game/company') }}">ゲーム会社一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('game/platform') }}">プラットフォーム一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('game/series') }}">シリーズ一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('review') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ url2('site') }}">サイト</a></li>
        <li class="list-group-item"><a href="{{ url2('diary') }}">日記</a></li>
        <li class="list-group-item"><a href="{{ url2('community') }}">コミュニティ</a></li>
        <li class="list-group-item"><a href="{{ url2('notice') }}">お知らせ</a></li>
        <li class="list-group-item"><a href="{{ route('システム更新履歴') }}">システム更新記録</a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>

        @if (\Illuminate\Support\Facades\Auth::check())
        <li class="list-group-item"><a href="{{ url2('mypage') }}">マイページ</a></li>
        @else
        <li class="list-group-item"><a href="{{ route('ログイン') }}">ログイン</a></li>
            <li class="list-group-item"><a href="{{ route('ユーザー登録') }}">ユーザー登録</a></li>
            <li class="list-group-item"><a href="{{ route('パスワード再設定') }}">パスワードを忘れた</a></li>
        @endif

        @if (is_data_editor())
        @endif

        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
    </ul>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイトマップ</li>
        </ol>
    </nav>
@endsection