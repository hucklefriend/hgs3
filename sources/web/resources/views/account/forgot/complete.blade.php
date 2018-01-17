@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')
    <h1>パスワード再設定完了</h1>

    <p>
        パスワードの再設定が完了しました。<br>
        <a href="{{ route('ログイン') }}">ログイン</a>
    </p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">パスワード再設定</li>
        </ol>
    </nav>
@endsection