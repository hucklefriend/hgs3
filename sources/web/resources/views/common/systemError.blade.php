@extends('layouts.app')

@section('title')エラー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')

    <h1>システムエラー</h1>
    <p>申し訳ありません、もう一度やり直してみてください。</p>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">システムエラー</li>
        </ol>
    </nav>
@endsection