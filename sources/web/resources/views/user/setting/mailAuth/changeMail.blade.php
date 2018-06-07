@extends('layouts.app')

@section('title')メールアドレス変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メールアドレス変更</h1>
        </header>

        <p>
            メールアドレスを入力して、確認メール送信ボタンを押してください。<br>
            入力されたメールアドレスに確認メールを送信しますので、24時間以内にメール本文に記載しているURLにアクセスして確定させてください。
        </p>
    </div>

    <form method="POST" action="{{ route('メールアドレス変更メール送信') }}" autocomplete="off" class="mt-5">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control{{ invalid($errors, 'email') }}" value="{{ old('email') }}" name="email" id="mail" required>
            <i class="form-group__bar"></i>
        </div>
        <div class="form-help">
            @include('common.error', ['formName' => 'email'])
        </div>
        <button type="submit" class="btn btn-primary">確認メール送信</button>
    </form>
@endsection
