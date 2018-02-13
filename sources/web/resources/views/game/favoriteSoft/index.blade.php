@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1>{{ $soft->name }}をお気に入りに登録しているユーザー</h1>

    @foreach ($favoriteUsers as $favoriteUser)
        <div class="mb-5">
            <div class="user-name-big">
                @include('user.common.icon', ['u' => $users[$favoriteUser->user_id]])
                @include('user.common.user_name', ['u' => $users[$favoriteUser->user_id]])
                <span style="font-size: 1rem;">{{ follow_status_icon($followStatus, $favoriteUser->user_id) }}</span>
            </div>
            <div>
                {{ format_date($favoriteUser->register_timestamp) }}登録
            </div>
        </div>
    @endforeach

    @include('common.pager', ['pager' => $favoriteUsers])

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">お気に入り登録ユーザー</li>
        </ol>
    </nav>
@endsection
