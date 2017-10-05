@extends('layouts.app')

@section('content')

    <h4>SNSのアカウントでログイン</h4>
    <div class="row">
        <div class="col-sm-3 text-center sns_link_outline text-warning">
            <a href="{{ url2('social/twitter') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::LOGIN }}" class="block_link sns_link sns_link_twitter">Twitter</a>
        </div>
        <div class="col-sm-3 text-center sns_link_outline text-warning">
            <a href="{{ url2('social/facebook') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::LOGIN }}" class="block_link sns_link sns_link_facebook">facebook</a>
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

    <h4>メールアドレスでログイン</h4>
    <form class="form-horizontal" method="POST">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="mail">パスワード</label>
            <input id="password" type="password" class="form-control" name="password" required>
        </div>
        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif

        <button type="submit" class="btn btn-primary">ログイン</button>
    </form>

@endsection
