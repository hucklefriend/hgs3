@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}">&lt;</a>
@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのフォロワー</h1>
    <hr>
    @include('user.profile.parts.follower', ['users' => $users, 'followers' => $followers])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザーページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザーのフォロワー</li>
        </ol>
    </nav>
@endsection
