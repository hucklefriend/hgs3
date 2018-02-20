@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ユーザー設定') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1>メール認証設定</h1>

    <p class="text-muted">
        <small>
            メールアドレスとパスワードを設定してください。<br>
            入力されたメールアドレスに確認メールを送信しますので、24時間以内にメール本文に記載しているURLにアクセスして登録を確定させてください。
        </small>
    </p>

    <form method="POST" action="{{ route('仮登録メール送信') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control{{ invalid($errors, 'mail') }}" value="{{ old('mail') }}" name="email" id="mail" required>
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control{{ invalid($errors, 'password') }}" id="password" name="password" required>
            @include('common.error', ['formName' => 'password'])
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード(同じものを)</label>
            <input type="password" class="form-control" id="password_confirmation{{ invalid($errors, 'password_confirmation') }}" name="password_confirmation" required>
            @include('common.error', ['formName' => 'password_confirmation'])
        </div>

        <button type="submit" class="btn btn-primary">仮登録メール送信</button>
    </form>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">設定</li>
        </ol>
    </nav>
@endsection