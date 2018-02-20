@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user])<span class="align-middle">{{ $user->name }}さんのページ</span></h1>

    <div class="mb-5">
        @if (!$isMyself)
            @if ($isFollow)
                <form action="{{ route('フォロー解除') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                    <button class="btn btn-danger btn-sm">フォロー解除</button>
                </form>
            @else
                <form action="{{ route('フォロー登録') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                    <button class="btn btn-primary btn-sm">フォロー</button>
                </form>
            @endif
        @endif

        @if (!empty($user->profile))
            <p class="profile-text">
                <span class="font-weight-bold">自己紹介</span><br>
                {!! nl2br(e($user->profile)) !!}
            </p>
        @endif

        @if ($isMyself)
            <div class="d-none d-sm-block">
                <div class="d-flex">
                    <div class="btn-group" role="group" aria-label="プロフィール">
                        <a href="{{ route('アイコン変更') }}" class="btn btn-outline-dark">アイコン変更</a>
                        <a href="{{ route('プロフィール編集') }}" class="btn btn-outline-dark">プロフィール編集</a>
                        <a href="{{ route('コンフィグ') }}" class="btn btn-outline-dark">設定</a>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('ログアウト') }}" class="btn btn-sm btn-warning">ログアウト</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- 最小表示以外はメニューと内容を表示 -->
    <div class="d-none d-sm-block">
        <div class="d-flex flex-row">
            <div class="p-2" style="width: 300px;">
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}" class="nav-link @if($show == 'timeline') active @endif" aria-expanded="true">タイムライン</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}" class="nav-link @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}" class="nav-link @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}" class="nav-link @if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteSoftNum }}個</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}" class="nav-link @if($show == 'review') active @endif" aria-expanded="true">レビュー {{ $reviewNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}" class="nav-link @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}" class="nav-link @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>
                </div>
            </div>
            <div class="p-10" style="width: 100%;">
                @include('user.profile.parts.' . camel_case($show), $parts)
            </div>
        </div>
    </div>

    <!-- 最小表示時はメニューのみ -->
    <div class="d-sm-none">
        <ul class="list-group">
            <li class="list-group-item">
                <a href="{{ route('ユーザーのタイムライン', ['showId' => $user->show_id]) }}">タイムライン</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーのフォロー', ['showId' => $user->show_id]) }}">フォロー</a>
                <span class="badge badge-secondary">{{ $followNum }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーのフォロワー', ['showId' => $user->show_id]) }}">フォロワー</a>
                <span class="badge badge-secondary">{{ $followerNum }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーのお気に入りゲーム', ['showId' => $user->show_id]) }}">お気に入りゲーム</a>
                <span class="badge badge-secondary">{{ $favoriteSoftNum }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーのレビュー', ['showId' => $user->show_id]) }}">レビュー</a>
                <span class="badge badge-secondary">{{ $reviewNum }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーのサイト', ['showId' => $user->show_id]) }}">サイト</a>
                <span class="badge badge-secondary">{{ $siteNum }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーのお気に入りサイト', ['showId' => $user->show_id]) }}">お気に入りサイト</a>
                <span class="badge badge-secondary">{{ $favoriteSiteNum }}</span>
            </li>
        </ul>

        @if ($isMyself)
        <hr>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="{{ route('アイコン変更') }}">アイコン変更</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('プロフィール編集') }}">プロフィール編集</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('コンフィグ') }}">設定</a>
            </li>
        </ul>
        <hr>
        <div class="text-center">
            <a href="{{ route('ログアウト') }}" class="btn btn-sm btn-warning">ログアウト</a>
        </div>

        @endif
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