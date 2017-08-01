@extends('layouts.app')

@section('content')

    <h5></h5>

    <div>
        {{ $communities->links() }}
    </div>

    <ul>
    @foreach ($communities as $c)
        <li></li>
    @endforeach
    </ul>

    <div>
        {{ $communities->links() }}
    </div>

@endsection