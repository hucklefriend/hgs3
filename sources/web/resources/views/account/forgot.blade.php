@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')
    <h1>パスワード再発行</h1>
    <p>
        登録しているメールアドレスを入力してください。<br>
        パスワード再設定のURLをお送りしますので、URLにアクセスしてパスワードを再設定してください。
    </p>

    <form method="POST" action="{{ route('パスワード再設定メール送信') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control" name="email" id="mail" required>
        </div>
        <button type="submit" class="btn btn-primary">パスワード再設定メール送信</button>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">パスワード再設定</li>
        </ol>
    </nav>
@endsection