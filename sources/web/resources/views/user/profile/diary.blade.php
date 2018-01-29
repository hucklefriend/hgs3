@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'diary']) }}">&lt;</a>
@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんの日記</h1>
    <hr>
    <p>日記は実装中</p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザーページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザーの日記</li>
        </ol>
    </nav>
@endsection