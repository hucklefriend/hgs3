@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>ログイン</h1>
    <section class="mt-5">
        <h1>SNSのアカウントでログイン</h1>
        <p class="pl-3">
            <small>
                他のSNSサービスのアカウントで登録できます。<br>
                登録後にログインに使うSNSを追加することもできます。<br>
                今のところ、Twitterにのみ対応しています。
            </small>
        </p>

        <div class="pl-3">
            <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Twitter\Mode::LOGIN]) }}">
                {{ csrf_field() }}
                <button class="btn btn-outline-info">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}&nbsp;Twitter</button>
            </form>
        </div>
    </section>

    <section class="mt-5">
        <h2>メールアドレスでログイン</h2>
        <div  class="pl-3">
            <form class="form-horizontal" method="POST" action="{{ route('ログイン処理') }}">
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
        </div>
    </section>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ログイン</li>
        </ol>
    </nav>
@endsection
