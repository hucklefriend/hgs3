@extends('layouts.app')

@section('title')メール認証設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <h1>メール認証設定</h1>
    <p>
        入力されたメールアドレスにメールを送信しました。<br>
        本文に記載しているURLにアクセスすると、メール認証設定が完了します。
    </p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定メール認証') }}">メール認証</a></li>
            <li class="breadcrumb-item active" aria-current="page">メール送信</li>
        </ol>
    </nav>
@endsection
