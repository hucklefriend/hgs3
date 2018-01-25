@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')

    <p>システムエラー</p>
    <p>申し訳ありません、もう一度やり直してみてください。</p>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">システムエラー</li>
        </ol>
    </nav>
@endsection