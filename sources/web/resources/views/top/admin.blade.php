@extends('layouts.admin')

@section('content')

    <h3>管理メニュー</h3>

    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url2('system/notice/admin') }}">お知らせ</a></li>
        <li class="list-group-item"><a href="{{ url2('system/update_history/admin') }}">システム更新履歴</a></li>
    </ul>

@endsection