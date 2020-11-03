@extends('layouts.app')

@section('title')メール認証設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メール認証設定</h1>
        </header>

        <p>
            入力されたメールアドレスにメールを送信しました。<br>
            本文に記載しているURLにアクセスすると、メール認証設定が完了します。
        </p>
    </div>
@endsection
