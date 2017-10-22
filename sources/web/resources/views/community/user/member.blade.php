@extends('layouts.app')

@section('content')

    <h5><a href="{{ url2('community/u') }}/{{ $userCommunity->id }}">{{ $userCommunity->name }}</a>のメンバー一覧</h5>

    <ul class="list-group">
        @foreach ($members as $member)
            <li class="list-group-item"><a href="{{ url2('user/profile') }}/{{ $member->user_id }}">{{ $users[$member->user_id] }}</a></li>
        @endforeach
    </ul>

@endsection