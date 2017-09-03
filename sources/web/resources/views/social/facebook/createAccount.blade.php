@extends('layouts.app')

@section('content')
    <h4>アカウント作成完了</h4>

    <pre>{{ print_r($user) }}</pre>

    <p><a href="{{ url2('social/facebook') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::LOGIN }}">ログイン</a></p>

@endsection