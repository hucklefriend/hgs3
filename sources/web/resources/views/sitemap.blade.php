@extends('layouts.app')

@section('content')
    <h4>サイトマップ</h4>

    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url2('') }}">トップページ</a></li>
        <li class="list-group-item"><a href="{{ url2('game') }}">ゲーム一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('game/company') }}">ゲーム会社一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('game/platform') }}">プラットフォーム一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('review') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ url2('site') }}">サイト</a></li>
        <li class="list-group-item"><a href="{{ url2('diary') }}">日記</a></li>
        <li class="list-group-item"><a href="{{ url2('community') }}">コミュニティ</a></li>
        <li class="list-group-item"><a href="{{ url2('') }}">ログイン</a></li>
        <li class="list-group-item"><a href="{{ url2('') }}">新規登録</a></li>


        @if (\Hgs3\Constants\UserRole::isUser())
            <li class="list-group-item"><a href="{{ url2('mypage') }}">マイページ</a></li>
        @endif

        @if (\Hgs3\Constants\UserRole::isDataEditor())
        @endif

        @if (\Hgs3\Constants\UserRole::isAdmin())
            <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        @endif

        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
    </ul>
@endsection