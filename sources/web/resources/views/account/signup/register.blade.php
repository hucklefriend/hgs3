@extends('layouts.app')

@section('content')
    <h3>ユーザー登録</h3>

    <form method="POST" action="{{ route('本登録処理') }}" autocomplete="off">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $pr->token }}">

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード(同じものを)</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button class="btn btn-primary">登録</button>
    </form>
@endsection
