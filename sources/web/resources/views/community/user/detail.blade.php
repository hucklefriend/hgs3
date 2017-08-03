@extends('layouts.app')

@section('content')

    <h5>{{ $uc->name }}</h5>

    <div>
        参加人数: {{ $uc->user_num }}
    </div>

    <div>
        <h6>メンバー</h6>
        <ul class="list-group">
            @foreach ($members as $u)
            <li class="list-group-item"></li>
            @endforeach
        </ul>
        ⇒ <a href="{{ url('community/u/members') }}/{{ $uc->id }}">もっと見る</a>
    </div>

@endsection