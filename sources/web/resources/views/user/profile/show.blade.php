@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'profile']) }}@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのプロフィール</h1>
    @include('user.profile.parts.profile', ['snsAccounts' => $snsAccounts])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">プロフィール</li>
        </ol>
    </nav>
@endsection
