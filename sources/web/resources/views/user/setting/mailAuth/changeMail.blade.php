@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ユーザー設定') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>メールアドレス変更</h1>

    <p class="text-muted">
        <small>
            メールアドレスを入力して、確認メール送信ボタンを押してください。<br>
            入力されたメールアドレスに確認メールを送信しますので、24時間以内にメール本文に記載しているURLにアクセスして確定させてください。
        </small>
    </p>

    <form method="POST" action="{{ route('メールアドレス変更メール送信') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control{{ invalid($errors, 'mail') }}" value="{{ old('mail') }}" name="email" id="mail" required>
            @include('common.error', ['formName' => 'name'])
        </div>
        <button type="submit" class="btn btn-primary">確認メール送信</button>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">メアド変更</li>
        </ol>
    </nav>
@endsection
