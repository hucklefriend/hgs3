@extends('layouts.app')

@section('content')

    <nav>
        <a href="{{ url('site/search') }}">サイト一覧</a>
    </nav>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"></div>
    </div>
@endsection