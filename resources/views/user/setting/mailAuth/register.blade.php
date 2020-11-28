@extends('layouts.app')

@section('title')メール認証設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メール認証設定</h1>
        </header>

        <p class="text-muted">
            メールアドレスとパスワードを設定してください。<br>
            入力されたメールアドレスに確認メールを送信しますので、24時間以内にメール本文に記載しているURLにアクセスして登録を確定させてください。
        </p>
    </div>

    <form method="POST" action="{{ route('メール認証仮登録メール送信') }}" autocomplete="off" class="mt-5">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control{{ invalid($errors, 'mail') }}" value="{{ old('mail') }}" name="email" id="mail" required>
            <i class="form-group__bar"></i>
        </div>
        <div class="form-help">
            @include('common.error', ['formName' => 'name'])
            <small class="form-text text-muted">
                4～16文字で入力してください。<br>
                使える文字は、アルファベット大文字小文字( A～Z a～z )、数字( 0～9 )、ハイフン( - )とアンダーバー( _ )です。
            </small>
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control{{ invalid($errors, 'password') }}" id="password" name="password" required maxlength="16">
            <i class="form-group__bar"></i>
        </div>
        <div class="form-help">
            @include('common.error', ['formName' => 'password'])
            <small class="form-text text-muted">
                4～16文字で入力してください。<br>
                使える文字は、アルファベット大文字小文字( A～Z a～z )、数字( 0～9 )、ハイフン( - )とアンダーバー( _ )です。
            </small>
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワード(同じものを)</label>
            <input type="password" class="form-control" id="password_confirmation{{ invalid($errors, 'password_confirmation') }}" name="password_confirmation" required maxlength="16">
            <i class="form-group__bar"></i>
        </div>
        <div class="form-help">
            @include('common.error', ['formName' => 'password_confirmation'])
            <small class="form-text text-muted">
                間違い防止のため、もう一度同じパスワードを入力してください。
            </small>
        </div>

        <button type="submit" class="btn btn-primary">仮登録メール送信</button>
    </form>
@endsection
