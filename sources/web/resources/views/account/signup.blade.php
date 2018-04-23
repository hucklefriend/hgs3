@extends('layouts.app')

@section('title')ユーザー登録@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ユーザー登録</h1>
        </header>


        <div class="card">
            <div class="card-body">
                <h4 class="card-title">はじめにお読みください</h4>

                <p>
                    テストの登録ユーザーがいっぱいいます。<br>
                    好きにフォローなど行ってください！<br>
                    テストユーザーは本運営開始時に全て削除します。
                </p>
                <p>
                    H.G.S.で登録していたメールアドレスで登録すると、サイト情報を引き継ぐことができます。<br>
                    {{ env('APP_NAME') }}のサイト登録画面で、引き継ぎを選択できますのでご利用ください。<br>
                    Twitterアカウントでの引き継ぎはまだ実装していませんが、いずれ実装します。
                </p>
                <p>
                    開発中のため、一部のデータが途中で消えるといったこともあり得ます。<br>
                    極力そうならないように進めていきますが、そういう事態の発生が起こり得ることはご了承ください。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">外部サイトのアカウントで登録</h4>
                <p>
                    外部サイトのアカウントで登録できます。<br>
                    登録後にログインに使う外部サイトを追加することもできます。
                </p>
                <div class="pl-3 d-flex">
                    <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</button>
                    </form>
                    <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }}</button>
                    </form>
                    <form method="POST" action="{{ route('GitHub', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</button>
                    </form>
                    <form method="POST" action="{{ route('Google', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GOOGLE_PLUS) }}</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">メールアドレスで登録</h4>
                <p>
                    ご自身のメールアドレスで登録できます。<br>
                    ↓にメールアドレスを入力し、仮登録メール送信ボタンを押してください。<br>
                    本登録のURLを記載したメールを送信します。<br>
                    ※SNSのアカウントで登録した後に、メールアドレスによるログイン設定を行うこともできます。
                </p>

                <form method="POST" action="{{ route('仮登録メール送信') }}" autocomplete="off" class="pl-3">
                    {{ csrf_field() }}

                    <div class="input-group mb-2">
                        <span class="input-group-addon" id="addon-mail"><i class="far fa-envelope"></i></span>
                        <div class="form-group">
                            <input id="email" type="email" class="form-control{{ invalid($errors, 'email') }}" name="email" value="{{ old('email') }}" required placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="addon-mail">
                            @include('common.error', ['formName' => 'email'])
                            <i class="form-group__bar"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">仮登録メール送信</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー登録</li>
        </ol>
    </nav>
@endsection
