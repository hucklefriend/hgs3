@extends('layouts.app')

@section('content')
    <div>
        <ul class="">
            @foreach ($list as $soft)
                <li><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection