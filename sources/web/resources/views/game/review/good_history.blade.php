@extends('layouts.app')

@section('content')

    <nav>
        <a href="{{ url('game/review/detail') }}/{{ $review->game_id }}/{{ $review->id }}">レビュー詳細に戻る</a>
    </nav>


    <h4>{{ $review->title }}にいいねした人たち</h4>

    <ul>
    @foreach ($histories as $history)
        <li>{{ $users[$history->user_id] }} - {{ $history->good_date }}</li>
    @endforeach
    </ul>

    {{ $histories->links() }}
@endsection