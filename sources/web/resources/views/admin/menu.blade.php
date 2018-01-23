@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('マイページ') }}">&lt;</a>
@endsection

@section('content')

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">管理メニュー</li>
        </ol>
    </nav>
@endsection