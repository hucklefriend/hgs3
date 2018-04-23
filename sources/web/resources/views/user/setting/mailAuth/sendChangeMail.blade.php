@extends('layouts.app')

@section('title')メールアドレス変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メールアドレス変更</h1>
        </header>

        <p>
            入力されたメールアドレスにメールを送信しました。<br>
            本文に記載しているURLにアクセスすると、メールアドレスの変更が完了します。
        </p>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">メアド変更</li>
        </ol>
    </nav>
@endsection
