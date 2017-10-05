@extends('layouts.app')

@section('content')
    <h4>SNSのアカウントで登録</h4>
    <p>
        他のSNSサービスのアカウントで登録できます。<br>
        登録後にログインに使うSNSを追加することもできます。
    </p>
    <div class="row">
        <div class="col-sm-3 text-center sns_link_outline text-warning">
            <a href="{{ url2('social/twitter') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT }}" class="block_link sns_link sns_link_twitter">Twitter</a>
        </div>
        <div class="col-sm-3 text-center sns_link_outline text-warning">
            <a href="{{ url2('social/facebook') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT }}" class="block_link sns_link sns_link_facebook">facebook</a>
        </div>
        <div class="col-sm-3 text-center sns_link_outline">
            GitHub
        </div>
        <div class="col-sm-3 text-center sns_link_outline">
            Instagarm
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 text-center sns_link_outline">Google+</div>
        <div class="col-sm-3 text-center sns_link_outline">Yahoo!</div>
        <div class="col-sm-3 text-center sns_link_outline">mixi</div>
        <div class="col-sm-3 text-center sns_link_outline">LINE</div>
    </div>

    <br><br>

    <h4>メールアドレスで登録</h4>
    <p>
        ご自身のメールアドレスで登録できます。<br>
        ↓にメールアドレスを入力し、仮登録メール送信ボタンを押してください。<br>
        本登録のURLを記載したメールを送信します。<br>
        ※SNSのアカウントで登録した後に、メールアドレスによるログイン設定を行うこともできます。
    </p>

    <form method="POST" action="{{ url2('account/signup/pr') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control" name="email" id="mail" required>
        </div>
        <button type="submit" class="btn btn-primary">仮登録メール送信</button>
    </form>
@endsection