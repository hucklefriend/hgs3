@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('master/game_platform/create') }}">新規登録</a>
    </div>

    <div>
        <ul class="">
            @foreach ($list as $platform)
                <li><a href="{{ url('master/game_platform') }}/{{ $platform->id }}">{{ $platform->name }}</a></li>
            @endforeach
        </ul>
    </div>

@endsection