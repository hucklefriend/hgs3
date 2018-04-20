@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    @if ($isMyself)
        <div class="d-flex mb-4">
            <div>
                <h1 class="mb-0">
                    @include('user.common.icon', ['u' => $user])
                    <span class="align-middle">{{ $user->name }}さんのページ</span>
                </h1>
            </div>
            <div class="ml-auto d-none d-sm-block">
                <a href="{{ route('ユーザー設定') }}" class="btn btn-sm btn-outline-dark mr-3"><i class="fas fa-cog"></i> 設定</a>
                <a href="{{ route('ログアウト') }}" class="btn btn-sm btn-warning" onclick="return confirm('ログアウトしていいですか？');">ログアウト</a>
            </div>
        </div>
    @else
        <div class="mb-4">
            <h1>
                @include('user.common.icon', ['u' => $user])<span class="align-middle">{{ $user->name }}さんのページ</span>
            </h1>
        </div>
    @endif

    <div class="d-flex flex-row">
        <div class="p-2 hidden-xs-down" style="width: 300px;">
            <div class="nav flex-column nav-pills ">
                <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'profile']) }}" class="nav-link @if($show == 'profile') active @endif" aria-expanded="true">プロフィール</a>
                <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}" class="nav-link @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}" class="nav-link @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}" class="nav-link @if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteSoftNum }}個</a>
                <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}" class="nav-link @if($show == 'review') active @endif" aria-expanded="true">レビュー {{ $reviewNum }}件</a>
                <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}" class="nav-link @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}" class="nav-link @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>
            </div>
        </div>
        <div class="p-10" style="width: 100%;">
            <div class="hidden-sm-up my-3">
                <div data-toggle="dropdown" class="cursor-pointer" style="line-height: 2rem;">
                    <span style="font-size: 1.5rem;">{{ $title }}</span>
                    <span style="margin-left: 1rem;font-size: 1rem;">▼</span>
                </div>

                <div class="dropdown-menu">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'profile']) }}" class="dropdown-item @if($show == 'profile') active @endif" aria-expanded="true">プロフィール</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}" class="dropdown-item @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}" class="dropdown-item @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}" class="dropdown-item @if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteSoftNum }}個</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}" class="dropdown-item @if($show == 'review') active @endif" aria-expanded="true">レビュー {{ $reviewNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}" class="dropdown-item @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}" class="dropdown-item @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>
                </div>
            </div>

            @include('user.profile.parts.' . camel_case($show), $parts)
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー</li>
        </ol>
    </nav>
@endsection