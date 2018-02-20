@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ユーザー設定') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1>メール認証設定完了</h1>

    <p>
        メール認証の設定が完了しました。<br>
        入力して頂いたパスワードでログインできます。
    </p>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定メール認証') }}">メール認証</a></li>
            <li class="breadcrumb-item active" aria-current="page">設定</li>
        </ol>
    </nav>
@endsection