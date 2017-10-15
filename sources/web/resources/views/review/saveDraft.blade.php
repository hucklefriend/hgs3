@extends('layouts.app')

@section('content')
    <h4>下書きを保存しました。</h4>

    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url2('game/soft') }}/{{ $game->id }}" class="block_link">{{ $game->name }}の詳細</a></li>
        <li class="list-group-item"><a href="{{ url2('review/game') }}/{{ $game->id }}" class="block_link">{{ $game->name }}のレビュー一覧</a></li>
        <li class="list-group-item"><a href="{{ url2('mypage/review') }}" class="block_link">自分のレビュー一覧</a></li>
    </ul>

@endsection