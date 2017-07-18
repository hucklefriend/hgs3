@extends('layouts.app')

@section('content')
    <div>レビューを投稿しました。</div>

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/soft') }}/{{ $game->id }}">詳細へ</a> |
        <a href="{{ url('game/review/detail') }}/{{ $reviewId }}">入力画面に戻る</a> |
        <a href="{{ url('user/review') }}">自分のレビュー一覧</a>
    </nav>

@endsection