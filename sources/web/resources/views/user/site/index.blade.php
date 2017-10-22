@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('user/site/add') }}">追加</a>
    </div>

    @foreach ($sites as $site)
        <div>
            <a href="{{ url('site/detail/' . $site->id }}">{{ $site->name }}</a>
        </div>
    @endforeach
@endsection