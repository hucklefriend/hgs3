@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url2('user/profile') }}/{{ $user->id }}">プロフィールに戻る</a>
    </div>

    {{ $communities->links() }}

    <ul class="list-group">
        @foreach ($communities as $c)
            <li class="list-group-item"><a href="{{ url2('community/g') }}/{{ $c->game_id }}">{{ $games[$c->game_id] ?? '---' }}</a></li>
        @endforeach
    </ul>

    {{ $communities->links() }}

@endsection