@extends('layouts.app')

@section('title')パスワード変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <h1>パスワード変更</h1>

    <form method="POST" action="{{ route('パスワード変更処理') }}" autocomplete="off">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control{{ invalid($errors, 'password') }}" id="password" name="password" required maxlength="16">
            @include('common.error', ['formName' => 'password'])
            <small class="form-text text-muted">
                4～16文字で入力してください。<br>
                使える文字は、アルファベット大文字( A～Z )、アルファベット小文字( a～z )、数字( 0～9 )、ハイフン( - )、アンダーバー( _ )です。
            </small>
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード(同じものを)</label>
            <input type="password" class="form-control" id="password_confirmation{{ invalid($errors, 'password_confirmation') }}" name="password_confirmation" required maxlength="16">
            @include('common.error', ['formName' => 'password_confirmation'])
            <small class="form-text text-muted">
                間違い防止のため、もう一度同じパスワードを入力してください。
            </small>
        </div>
        <button type="submit" class="btn btn-primary">パスワード変更</button>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">パスワード変更</li>
        </ol>
    </nav>
@endsection