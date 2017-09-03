@extends('layouts.app')

@section('content')

    <h3>ユーザー登録</h3>

    <div class="row">
        <div class="col-md-4"><a href="{{ url2('social/twitter') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT }}">Twitter</a></div>
        <div class="col-md-4"><a href="{{ url2('social/facebook') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::CREATE_ACCOUNT }}">facebook</a></div>
        <div class="col-md-4"><a href="{{ url2('social/github') }}">GitHub</a></div>
    </div>
    <div class="row">
        <div class="col-md-4">Google+</div>
        <div class="col-md-4">Yahoo!</div>
        <div class="col-md-4">mixi</div>
    </div>

    <p>
        仮登録メール送信
    </p>

    <form method="POST" action="{{ url2('account/signup/pr') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control" name="email" id="mail">
        </div>
        <button type="submit" class="btn btn-primary">仮登録メール送信</button>
    </form>
@endsection