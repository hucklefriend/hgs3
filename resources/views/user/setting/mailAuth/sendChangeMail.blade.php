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

