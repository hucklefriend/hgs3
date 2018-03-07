@extends('layouts.app')

@section('title')ログイン @endsection

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>ログイン</h1>
    <section class="mt-5">
        <h2>外部サイトのアカウントでログイン</h2>

        <div class="pl-3">
            <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                {{ csrf_field() }}
                <button class="btn btn-outline-info">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}&nbsp;Twitter</button>
            </form>
            <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                {{ csrf_field() }}
                <button class="btn btn-outline-info">{{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }}&nbsp;facebook</button>
            </form>
            <form method="POST" action="{{ route('GitHub', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                {{ csrf_field() }}
                <button class="btn btn-outline-info">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}&nbsp;GitHub</button>
            </form>
            <form method="POST" action="{{ route('Google', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                {{ csrf_field() }}
                <button class="btn btn-outline-info">{{ sns_icon(\Hgs3\Constants\SocialSite::GOOGLE_PLUS) }}&nbsp;Google+</button>
            </form>
        </div>
    </section>

    <section class="mt-5">
        <h2>メールアドレスでログイン</h2>
        <div class="pl-3">
            <form class="form-horizontal" method="POST" action="{{ route('ログイン処理') }}">
                {{ csrf_field() }}

                <div class="form-group form-group-sm mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-mail"><i class="far fa-envelope"></i></span>
                        </div>
                        <input id="email" type="email" class="form-control {{ $errors->has('login_error') ? ' has-danger' : '' }}" name="email" value="{{ old('email') }}" required placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="addon-mail">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-password"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control{{ $errors->has('login_error') ? ' has-danger' : '' }}" name="password" required placeholder="パスワード" aria-label="パスワード" aria-describedby="addon-password">
                    </div>
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

    <p class="mt-5">
        <a href="{{ route('パスワード再設定') }}">パスワードを忘れた場合はこちら</a>
    </p>
    <p>
        <a href="{{ route('ユーザー登録') }}">ユーザー登録はこちら</a>
    </p>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ログイン</li>
        </ol>
    </nav>
@endsection
