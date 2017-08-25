@extends('layouts.app')

@section('content')
    <h4>このアカウントは既に登録されています。</h4>

    <p><a href="{{ url2('social/twitter') }}/{{ \Hgs3\Constants\Social\Twitter\Mode::LOGIN }}">ログイン</a></p>

@endsection