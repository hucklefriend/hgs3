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
