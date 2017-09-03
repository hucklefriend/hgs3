@extends('layouts.app')

@section('content')
    <h4>このアカウントは登録されていません。</h4>

    <p><a href="{{ url2('account/signup') }}">新規登録</a></p>

@endsection