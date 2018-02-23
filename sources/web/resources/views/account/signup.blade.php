@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1>新規登録</h1>


    <h2>はじめにお読みください</h2>
    <p class="pl-3">
        <small>
            退会をまだ実装していないため、退会を行うことができません。<br>
            いずれ実装予定です。
        </small>
    </p>
    <p class="pl-3">
        <small>
            テストの登録ユーザーがいっぱいいます。<br>
            好きにフォローなど行ってください！<br>
            テストユーザーは本運営開始時に全て削除します。
        </small>
    </p>
    <p class="pl-3">
        <small>
            H.G.S.で登録していたメールアドレスで登録すると、サイト情報を引き継ぐことができます。<br>
            H.G.N.のサイト登録画面で、引き継ぎを選択できますのでご利用ください。<br>
            Twitterアカウントでの引き継ぎはまだ実装していませんが、いずれ実装します。
        </small>
    </p>

    <section class="mt-5">
        <h2>SNSのアカウントで登録</h2>
        <p class="pl-3">
            <small>
                他のSNSサービスのアカウントで登録できます。<br>
                登録後にログインに使うSNSを追加することもできます。<br>
                今のところ、Twitterにのみ対応しています。
            </small>
        </p>

        <div class="pl-3">
            <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT]) }}">
                {{ csrf_field() }}
                <button class="btn btn-outline-info">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}&nbsp;Twitter</button>
            </form>
        </div>
    </section>

    <section class="mt-5">
        <h2>メールアドレスで登録</h2>
        <p class="pl-3">
            <small>
                ご自身のメールアドレスで登録できます。<br>
                ↓にメールアドレスを入力し、仮登録メール送信ボタンを押してください。<br>
                本登録のURLを記載したメールを送信します。<br>
                ※SNSのアカウントで登録した後に、メールアドレスによるログイン設定を行うこともできます。
            </small>
        </p>

        <form method="POST" action="{{ route('仮登録メール送信') }}" autocomplete="off" class="pl-3">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="mail">メールアドレス</label>
                <input type="email" class="form-control" name="email" id="mail" required>
            </div>
            <button type="submit" class="btn btn-primary">仮登録メール送信</button>
        </form>
    </section>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー登録</li>
        </ol>
    </nav>
@endsection