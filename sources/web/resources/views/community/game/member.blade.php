@extends('layouts.app')

@section('content')

    <h5><a href="{{ url2('community/g/' . $soft->id) }}">{{ $soft->name }}</a>のメンバー一覧</h5>

    <ul class="list-group">
        @foreach ($members as $u)
            <li class="list-group-item"><a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $users[$u] ?? '---' }}</a></li>
        @endforeach
    </ul>

@endsection