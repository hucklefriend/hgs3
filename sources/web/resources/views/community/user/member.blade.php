@extends('layouts.app')

@section('content')

    <h5><a href="{{ url2('community/u') }}/{{ $uc->id }}">{{ $uc->name }}</a>のメンバー一覧</h5>

    <ul class="list-group">
        @foreach ($members as $u)
            <li class="list-group-item"><a href="{{ url2('user/profile') }}/{{ $u->user_id }}">{{ $users[$u->user_id] }}</a></li>
        @endforeach
    </ul>

@endsection