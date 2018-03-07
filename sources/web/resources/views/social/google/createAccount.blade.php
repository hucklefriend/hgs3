@extends('layouts.app')

@section('content')
    <h1>アカウント作成完了</h1>

    <p>
        Google+でのアカウントの作成に成功しました。<br>
        ログイン画面より、ログインを行ってください。
    </p>

    <p>
        <a href="{{ route('ログイン') }}">ログイン</a>
    </p>

@endsection