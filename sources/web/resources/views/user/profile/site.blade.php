@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}">&lt;</a>
@endsection

@section('content')

    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのサイト</h1>

    <hr>

    @include('user.profile.parts.site', ['sites' => $sites, 'hasHgs2Site' => $hasHgs2Site])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザーページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザーのサイト</li>
        </ol>
    </nav>
@endsection
