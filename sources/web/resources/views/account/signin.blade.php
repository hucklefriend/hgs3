@extends('layouts.app')

@section('content')


    <h3>ユーザー登録</h3>

    <p>
        仮登録メール送信
    </p>

    <form method="POST" action="{{ url2('account/signup/first') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input type="email" class="form-control" id="mail">
        </div>
        <button type="submit" class="btn btn-primary">仮登録メール送信</button>
    </form>
@endsection