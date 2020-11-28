@extends('layouts.app')

@section('title')パスワード再発行@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>パスワード再発行</h1>
        </header>
        <p>
            登録しているメールアドレスを入力してください。<br>
            パスワード再設定のURLをお送りしますので、URLにアクセスしてパスワードを再設定してください。
        </p>

        <form method="POST" action="{{ route('パスワード再設定メール送信') }}" autocomplete="off" class="mt-5">
            {{ csrf_field() }}

            <div class="input-group mb-2">
                <span class="input-group-addon" id="addon-mail"><i class="far fa-envelope"></i></span>
                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('emal') ? ' has-danger' : '' }}" name="email" required placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="addon-mail">
                    <i class="form-group__bar"></i>
                </div>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'email'])
            </div>

            <button type="submit" class="btn btn-primary">パスワード再設定メール送信</button>
        </form>
    </div>
@endsection
