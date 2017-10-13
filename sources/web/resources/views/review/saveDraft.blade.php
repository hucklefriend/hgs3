@extends('layouts.app')

@section('content')
    <div>下書きを保存しました。</div>

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/soft') }}/{{ $gameId }}">詳細へ</a> |
        <a href="{{ url('review/input') }}/{{ $gameId }}">入力画面に戻る</a> |
        <a href="{{ url('user/review') }}">自分のレビュー一覧</a>
    </nav>

@endsection