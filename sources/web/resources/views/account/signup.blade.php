@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <section>
        <h2>SNSのアカウントで登録</h2>
        <p>
            他のSNSサービスのアカウントで登録できます。<br>
            登録後にログインに使うSNSを追加することもできます。<br>
            今のところ、Twitterにのみ対応しています。
        </p>

        <div>
            <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT]) }}">
                {{ csrf_field() }}
                <button class="btn btn-outline-info">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}&nbsp;Twitter</button>
            </form>
        </div>

        <div class="row d-none">
            <div class="col-sm-3 text-center sns-link-outline text-warning">

            </div>
            <div class="col-sm-3 text-center sns-link-outline" style="display:none;">
                facebook
            </div>
            <div class="col-sm-3 text-center sns-link-outline" style="display:none;">
                GitHub
            </div>
            <div class="col-sm-3 text-center sns-link-outline" style="display:none;">
                Instagarm
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col-sm-3 text-center sns-link-outline">Google+</div>
            <div class="col-sm-3 text-center sns-link-outline">Yahoo!</div>
            <div class="col-sm-3 text-center sns-link-outline">mixi</div>
            <div class="col-sm-3 text-center sns-link-outline">LINE</div>
        </div>
    </section>

    <br><br>

    <section>
        <h4>メールアドレスで登録</h4>
        <p>
            ご自身のメールアドレスで登録できます。<br>
            ↓にメールアドレスを入力し、仮登録メール送信ボタンを押してください。<br>
            本登録のURLを記載したメールを送信します。<br>
            ※SNSのアカウントで登録した後に、メールアドレスによるログイン設定を行うこともできます。
        </p>

        <form method="POST" action="{{ route('仮登録メール送信') }}" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="mail">メールアドレス</label>
                <input type="email" class="form-control" name="email" id="mail" required>
            </div>
            <button type="submit" class="btn btn-primary">仮登録メール送信</button>
        </form>
    </section>

    <br><br>

    <section>
        <h4>H.G.S.から引き継ぎ</h4>
        <p>
            H.G.S.で登録していたメールアドレス、またはTwitterアカウントで登録すると、サイト情報を引き継ぐことができます。<br>
            アカウント登録後に、H.G.S.で利用していたメールアドレスまたはTwitterアカウントへ変更しても引き継げます。<br>
            引き継ぎはサイト登録画面で行えます。
        </p>
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