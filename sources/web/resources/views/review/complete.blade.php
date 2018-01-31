@extends('layouts.app')

@section('content')
    <div>レビューを投稿しました。</div>

    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ url2('review/soft/' . $soft->id) }}" class="block-link">{{ $soft->name }}のレビュー一覧</a>
        </li>
        <li class="list-group-item">
            <a href="{{ url2('review/detail/' . $reviewId) }}" class="block-link">{{ $soft->name }}投稿したレビューの確認</a>
        </li>
        <li class="list-group-item">
            <a href="{{ url2('user/review') }}" class="block-link">自分のレビュー一覧</a>
        </li>
    </ul>

@endsection