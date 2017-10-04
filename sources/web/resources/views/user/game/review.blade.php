@extends('layouts.app')

@section('content')

    <h2>{{ $user->name }}さんが投稿したレビュー</h2>

    {{ $reviews }}

    @foreach ($reviews as $r)
        @include('game.review.common.no_user', ['r' => $r])
        @if (!$loop->last)
            <hr>
        @endif
    @endforeach

    {{ $reviews }}
@endsection