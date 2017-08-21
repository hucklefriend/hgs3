@extends('layouts.app')

@section('content')

    <section>
        <h5>{{ $user->name }}さんの遊んだゲーム</h5>
    </section>

    <div>
        <a href="{{ url('user/profile') }}/{{ $user->id }}">プロフィール</a> |
    @if ($isMyself)
        <a href="{{ url('user/profile/edit') }}">プロフィール編集</a>
    @endif
    </div>

    <hr>


    {{ $playedGames->links() }}

    @foreach ($playedGames as $pg)
        <div>
            <a href="{{ url2('game/soft') }}/{{ $pg->game_id }}">{{ $games[$pg->game_id] }}</a>
            <pre>{{ $pg->comment }}</pre>
        </div>
        <hr>
    @endforeach

    {{ $playedGames->links() }}

@endsection