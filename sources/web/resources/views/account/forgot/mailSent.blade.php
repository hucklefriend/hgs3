@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1>パスワード再設定メール送信完了</h1>
    <p>1時間以内にメールからアクセスし、パスワードの再設定を行ってください。</p>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">パスワード再設定</li>
        </ol>
    </nav>
@endsection