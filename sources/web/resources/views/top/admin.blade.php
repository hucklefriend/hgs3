@extends('layouts.admin')

@section('content')

    <h3>管理メニュー</h3>

    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url2('system/notice') }}">お知らせ</a></li>
    </ul>

@endsection