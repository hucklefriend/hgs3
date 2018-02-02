@extends('layouts.app')

@section('content')
    <h4>このアカウントは既に登録されています。</h4>

    <p><a href="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">ログイン</a></p>

@endsection