@extends('layouts.app')

@section('title')Google+でユーザー登録@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('ログイン') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>Google+でユーザー登録完了</h1>
        </header>

        <p>
            Google+でのアカウントの作成に成功しました。<br>
            ログイン画面より、ログインを行ってください。
        </p>

        <p>
            <a href="{{ route('ログイン') }}">ログイン</a>
        </p>
    </div>
@endsection