@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイトトップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>タイムライン</h1>

    <div class="d-flex flex-row">
        <div class="d-none d-sm-block">
            <div class="site-side-menu">
                @include('site.common.sideMenu', ['active' => 'タイムライン'])
            </div>
        </div>
        <div style="width: 100%;">
            @foreach ($timelines as $timeline)
                <p class="mb-4">
                    {{ date('Y-m-d H:i', $timeline->time) }}<br>
                    {!! nl2br($timeline->text) !!}
                </p>
            @endforeach
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイトタイムライン</li>
        </ol>
    </nav>
@endsection