@extends('layouts.app')

@section('title')メール認証設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メール認証設定完了</h1>
        </header>

        <p>
            メール認証の設定が完了しました。<br>
            入力して頂いたパスワードでログインできます。
        </p>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">メール認証設定完了</li>
        </ol>
    </nav>
@endsection