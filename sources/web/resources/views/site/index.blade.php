@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')
    <h1>サイト</h1>

    <div class="d-flex flex-row d-none d-sm-block">
        <div style="width: 250px;">
            @include('site.common.sideMenu', ['active' => ''])
        </div>
        <div style="width: 100%;">
        </div>
    </div>

    <div class="d-sm-none">
        @include('site.common.sideMenu', ['active' => ''])
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト</li>
        </ol>
    </nav>
@endsection