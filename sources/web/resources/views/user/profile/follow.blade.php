@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">&lt;</a>
@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのフォロー</h1>
    <hr>
    @include('user.profile.parts.follow', ['users' => $users, 'follows' => $follows])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザーページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザーのフォロー</li>
        </ol>
    </nav>
@endsection
