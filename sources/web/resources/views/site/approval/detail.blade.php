@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('承認待ちサイト一覧') }}">&lt;</a>
@endsection

@section('content')


@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('管理メニュー') }}">管理メニュー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('承認待ちサイト一覧') }}">サイト承認</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト承認実行</li>
        </ol>
    </nav>
@endsection