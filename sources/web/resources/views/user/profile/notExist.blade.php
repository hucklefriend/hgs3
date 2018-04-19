@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')

    <h1>ユーザーが見つかりませんでした。</h1>

    <p>
        指定されたユーザーが見つかりませんでした。<br>
        退会されたのかもしれません。
    </p>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー</li>
        </ol>
    </nav>
@endsection