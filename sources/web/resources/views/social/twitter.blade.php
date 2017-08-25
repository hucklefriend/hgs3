@extends('layouts.app')

@section('content')
    aaa

    <pre>{{ $mode }}</pre>
    <hr>
    <pre>{{ print_r($user, true) }}</pre>
@endsection