@extends('layouts.app')

@section('content')
    <h4>アカウント作成完了</h4>

    <p><a href="{{ url2('soial/twitter') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::LOGIN }}">ログイン</a></p>

@endsection