@extends('layouts.app')

@section('content')
    <h4>ゲーム会社一覧</h4>

    @if (\Hgs3\Constants\UserRole::isDataEditor())
    <div class="text-right">
        <a href="{{ url2('game/company/add') }}">ゲーム会社を追加</a>
    </div>
    @endif

    <ul class="list-group">
    @foreach ($companies as $c)
        <li class="list-group-item"><a href="{{ url('game/company') }}/{{ $c->id }}">{{ $c->name }}</a></li>
    @endforeach
    </ul>
@endsection