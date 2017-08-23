@extends('layouts.app')

@section('content')


    <p>メール送信は後回しでとりあえずアクセス</p>
    <div>
        <a href="{{ url2('account/register') }}/{{ urlencode($token) }}">ここから</a>
    </div>

@endsection