@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('user/site/add') }}">追加</a>
    </div>

    @foreach ($sites as $s)
        <div>
            <a href="{{ url('site/detail') }}/{{ $s->id }}">{{ $s->name }}</a>
        </div>
    @endforeach
@endsection