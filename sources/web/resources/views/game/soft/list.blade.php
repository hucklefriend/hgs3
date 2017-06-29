@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('game/request/') }}">追加リクエスト</a> |
        <a href="{{ url('game/request') }}">追加リクエスト一覧</a>
    </div>

    <div>
        @foreach ($phoneticList as $phoneticId => $phoneticChar)
            <h4>{{ $phoneticChar }}</h4>
            <ul class="">
                @if (isset($list[$phoneticId]))
                @foreach ($list[$phoneticId] as $soft)
                    <li><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                @endforeach
                @endif
            </ul>
        @endforeach
    </div>
@endsection