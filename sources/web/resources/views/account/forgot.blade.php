@extends('layouts.app')

@section('title')パスワード再発行@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <h1>パスワード再発行</h1>
    <p>
        登録しているメールアドレスを入力してください。<br>
        パスワード再設定のURLをお送りしますので、URLにアクセスしてパスワードを再設定してください。
    </p>

    <form method="POST" action="{{ route('パスワード再設定メール送信') }}" autocomplete="off" class="mt-5">
        {{ csrf_field() }}
        <div class="form-group form-group-sm mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-mail"><i class="far fa-envelope"></i></span>
                </div>
                <input id="email" type="email" class="form-control {{ $errors->has('login_error') ? ' has-danger' : '' }}" name="email" required placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="addon-mail">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">パスワード再設定メール送信</button>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">パスワード再設定</li>
        </ol>
    </nav>
@endsection