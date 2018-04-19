@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのタイムライン</h1>
    <hr>
    @include('user.profile.parts.timeline', ['timelines' => $timelines])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">タイムライン</li>
        </ol>
    </nav>
@endsection
