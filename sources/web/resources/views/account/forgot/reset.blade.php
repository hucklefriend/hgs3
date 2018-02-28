@extends('layouts.app')

@section('content')
    <h1>パスワード再設定</h1>

    <form method="POST" action="{{ route('パスワード再設定処理') }}" autocomplete="off">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $pr->token }}">
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード(同じものを)</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <div style="display:flex;">
            <div>
                <button class="btn btn-primary">登録</button>
            </div>
            <div style="margin-left: auto;">
                <a href="{{ route('パスワード再設定') }}">パスワードを忘れた</a>
            </div>
        </div>
    </form>
@endsection
