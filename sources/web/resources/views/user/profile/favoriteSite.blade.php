@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのお気に入りサイト</h1>
    <hr>
    @include('user.profile.parts.favoriteSite')
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">お気に入りサイト</li>
        </ol>
    </nav>
@endsection
