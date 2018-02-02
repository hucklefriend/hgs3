@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>サイト</h1>

    <div class="d-none d-sm-block">
        <div class="d-flex flex-row">
            <div class="site-side-menu">
                @include('site.common.sideMenu', ['active' => 'タイムライン'])
            </div>
            <div style="width: 100%;">
                @foreach ($timelines as $timeline)
                    {!! nl2br($timeline->text) !!}
                    <hr>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-sm-none">
        @include('site.common.sideMenu', ['active' => ''])
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト</li>
        </ol>
    </nav>
@endsection