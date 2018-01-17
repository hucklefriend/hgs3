@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')
    <section>
        <h4>SNSのアカウントで登録</h4>
        <p>
            他のSNSサービスのアカウントで登録できます。<br>
            登録後にログインに使うSNSを追加することもできます。
        </p>
        <div class="row">
            <div class="col-sm-3 text-center sns_link_outline text-warning">
                <a href="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT]) }}" class="block_link sns_link sns_link_twitter">Twitter</a>
            </div>
            <div class="col-sm-3 text-center sns_link_outline text-warning">
                <a href="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT]) }}" class="block_link sns_link sns_link_facebook">facebook</a>
            </div>
            <div class="col-sm-3 text-center sns_link_outline" style="display:none;">
                GitHub
            </div>
            <div class="col-sm-3 text-center sns_link_outline" style="display:none;">
                Instagarm
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col-sm-3 text-center sns_link_outline">Google+</div>
            <div class="col-sm-3 text-center sns_link_outline">Yahoo!</div>
            <div class="col-sm-3 text-center sns_link_outline">mixi</div>
            <div class="col-sm-3 text-center sns_link_outline">LINE</div>
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

        <form method="POST" action="{{ route('仮登録メール送信') }}">
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
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー登録</li>
        </ol>
    </nav>
@endsection