@extends('layouts.app')

@section('title')ログイン@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ログイン</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">外部サイトのアカウントでログイン</h4>

                <div class="d-flex">
                    <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</button>
                    </form>
                    <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }}</button>
                    </form>
                    <form method="POST" action="{{ route('GitHub', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</button>
                    </form>
                    <form method="POST" action="{{ route('Google', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GOOGLE_PLUS) }}</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">メールアドレスでログイン</h4>

                <div>
                    <form class="form-horizontal" method="POST" action="{{ route('ログイン処理') }}">
                        {{ csrf_field() }}

                        <div class="input-group mb-2">
                            <span class="input-group-addon" id="addon-mail"><i class="far fa-envelope"></i></span>
                            <div class="form-group">
                                <input id="email" type="email" class="form-control{{ $errors->has('login_error') ? ' has-danger' : '' }}" name="email" value="{{ old('email') }}" required placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="addon-mail">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-addon" id="addon-password"><i class="fas fa-key"></i></span>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control{{ $errors->has('login_error') ? ' has-danger' : '' }}" name="password" required placeholder="パスワード" aria-label="パスワード" aria-describedby="addon-password">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>

                        @if ($errors->has('login_error'))
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->get('login_error') as $msg)
                                    {{ nl2br(e($msg)) }}
                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary mt-3">ログイン</button>
                    </form>
                </div>


                <p class="mt-5">
                    <a href="{{ route('パスワード再設定') }}">パスワードを忘れた場合はこちら</a>
                </p>
                <p>
                    <a href="{{ route('ユーザー登録') }}">ユーザー登録はこちら</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        $(function (){
            $('#global_back').click(function (e){
                e.preventDefault();

                history.back();

                return false;
            });
        });
    </script>
@endsection

