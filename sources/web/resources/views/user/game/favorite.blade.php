@extends('layouts.app')

@section('content')

    <section>
        <h5>{{ $user->name }}さんのお気に入りゲーム</h5>
    </section>

    <div>
        <a href="{{ url('user/profile') }}/{{ $user->id }}">プロフィール</a> |
    @if ($isMyself)
        <a href="{{ url('user/profile/edit') }}">プロフィール編集</a>
    @endif
    </div>

    <hr>

    @foreach ($favGames as $fg)
        <div>
            {{ $games[$fg->game_id] }}
        </div>
        <hr>
    @endforeach

@endsection