@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのレビュー</h1>
    <hr>
    <p>レビューは実装中</p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー</li>
        </ol>
    </nav>
@endsection