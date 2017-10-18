@extends('layouts.app')

@section('content')
    <h4>ゲームシリーズ一覧</h4>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ url2('game/series/add') }}">ゲームシリーズを追加</a>
    </div>
    @endif

    <ul class="list-group">
    @foreach ($series as $s)
        <li class="list-group-item"><a href="{{ url('game/series/' . $s->id) }}">{{ $s->name }}</a></li>
    @endforeach
    </ul>

    {{ $series->links() }}
@endsection