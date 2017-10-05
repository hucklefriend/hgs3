@extends('layouts.app')

@section('content')
    <ul class="list-group">
    @foreach ($companies as $c)
        <li class="list-group-item"><a href="{{ url('game/company') }}/{{ $c->id }}">{{ $c->name }}</a></li>
    @endforeach
    </ul>
@endsection