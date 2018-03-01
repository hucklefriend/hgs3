@extends('layouts.app')

@section('title')ユーザー登録 @endsection

@section('content')
    <h1>ユーザー登録</h1>

    <form method="POST" action="{{ route('本登録処理') }}" autocomplete="off">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $pr->token }}">

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name') }}" required maxlength="100">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control{{ invalid($errors, 'password') }}" id="password" name="password" required minlength="4" maxlength="16">
            @include('common.error', ['formName' => 'password'])
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード(同じものを)</label>
            <input type="password" class="form-control{{ invalid($errors, 'password_confirmation') }}" id="password_confirmation" name="password_confirmation" required minlength="4" maxlength="16">
            @include('common.error', ['formName' => 'password_confirmation'])
        </div>
        <button class="btn btn-primary">登録</button>
    </form>
@endsection
