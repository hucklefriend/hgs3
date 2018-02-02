@extends('layouts.app')

@section('content')
    <h4>アカウント作成完了</h4>

    <p><a href="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">ログイン</a></p>

@endsection