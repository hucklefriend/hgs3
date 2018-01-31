@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')

    <h4>SNSのアカウントでログイン</h4>
    <div class="row">
        <div class="col-sm-3 text-center sns-link-outline text-warning">
            <a href="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}" class="block-link sns-link sns-link-twitter">Twitter</a>
        </div>
        <div class="col-sm-3 text-center sns-link-outline text-warning">
            <a href="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}" class="block-link sns-link sns-link-facebook">facebook</a>
        </div>
        <div class="col-sm-3 text-center sns-link-outline">
            GitHub
        </div>
        <div class="col-sm-3 text-center sns-link-outline">
            Instagarm
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 text-center sns-link-outline">Google+</div>
        <div class="col-sm-3 text-center sns-link-outline">Yahoo!</div>
        <div class="col-sm-3 text-center sns-link-outline">mixi</div>
        <div class="col-sm-3 text-center sns-link-outline">LINE</div>
    </div>

    <br><br>

    <h4>メールアドレスでログイン</h4>
    <form class="form-horizontal" method="POST" action="{{ route('ログイン処理') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="mail">メールアドレス</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="mail">パスワード</label>
            <input id="password" type="password" class="form-control" name="password" required>
        </div>
        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif

        <button type="submit" class="btn btn-primary">ログイン</button>
    </form>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ログイン</li>
        </ol>
    </nav>
@endsection
