@extends('layouts.app')

@section('title')Twitterでユーザー登録@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('ログイン') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>Twitterでユーザー登録完了</h1>
        </header>

        <p>
            Twitterでのアカウントの作成に成功しました。<br>
            ログイン画面より、ログインを行ってください。
        </p>

        <p>
            <a href="{{ route('ログイン') }}">ログイン</a>
        </p>
    </div>
@endsection