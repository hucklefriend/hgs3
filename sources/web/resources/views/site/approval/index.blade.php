@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('管理メニュー') }}">&lt;</a>
@endsection

@section('content')
    <table>

    </table>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('管理メニュー') }}">管理メニュー</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト承認</li>
        </ol>
    </nav>
@endsection