@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'played_game']) }}@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんの遊んだゲーム</h1>
    <hr>
    <p>遊んだゲームは実装中</p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">遊んだゲーム</li>
        </ol>
    </nav>
@endsection
