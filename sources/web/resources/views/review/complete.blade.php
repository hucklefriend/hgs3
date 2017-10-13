@extends('layouts.app')

@section('content')
    <div>レビューを投稿しました。</div>

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('review/soft') }}/{{ $game->id }}">{{ $game->name }}のレビュー一覧</a>
        <a href="{{ url('review/detail') }}/{{ $reviewId }}">レビューの詳細へ</a>
        <a href="{{ url('user/review') }}">自分のレビュー一覧</a>
    </nav>

@endsection