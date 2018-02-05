@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>ゲームシリーズ一覧</h1>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ route('シリーズ') }}">ゲームシリーズを追加</a>
    </div>
    @endif

    <ul class="list-group">
    @foreach ($series as $s)
        <li class="list-group-item"><a href="{{ url('game/series/' . $s->id) }}">{{ $s->name }}</a></li>
    @endforeach
    </ul>

    {{ $series->links() }}
@endsection