@extends('layouts.app')

@section('content')
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url2('') }}">トップページ</a></li>
        <li class="list-group-item"><a href="{{ url2('game/soft') }}">ゲーム一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('game/company') }}">ゲーム会社一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('game/hard') }}">ハード一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('game/review') }}">レビュー</a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>



        @if (\Hgs3\Constants\UserRole::isUser())
        @endif

        @if (\Hgs3\Constants\UserRole::isDataEditor())
        @endif

        @if (\Hgs3\Constants\UserRole::isAdmin())
            <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
        @endif

        <li class="list-group-item"><a href="{{ url2('') }}"></a></li>
    </ul>
@endsection