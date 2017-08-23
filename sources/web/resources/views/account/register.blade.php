@extends('layouts.app')

@section('content')


    <h3>ユーザー登録</h3>

    <form method="POST" action="{{ url2('account/register') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $pr->token }}">

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード(同じものを)</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <button class="btn btn-primary">登録</button>
    </form>
@endsection