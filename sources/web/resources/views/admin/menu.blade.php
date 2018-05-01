@extends('layouts.app')

@section('title')管理メニュー@endsection
@section('global_back_link'){{ route('マイページ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ env('APP_NAME') }}について</h1>
        </header>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">管理メニュー</li>
        </ol>
    </nav>
@endsection
