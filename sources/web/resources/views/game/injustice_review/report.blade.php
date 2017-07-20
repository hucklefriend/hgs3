@extends('layouts.app')

@section('content')

    <p>
        不正報告を受け付けました。<br>
        報告の状態は<a href="{{ url('user/injustice/review') }}">不正報告一覧</a>から確認できます。
    </p>

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/review') }}">レビュートップに戻る</a>
    </nav>

@endsection