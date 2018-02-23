@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    @if ($isMyself)
        <div class="d-flex mb-4">
            <div>
                <h1 class="mb-0">
                    @include('user.common.icon', ['u' => $user])
                    <span class="align-middle">{{ $user->name }}さんのページ</span>
                </h1>
                <div>
                    @foreach ($snsAccounts as $sns)
                        <a href="{{ $sns->getUrl() }}" target="_blank">{{ sns_icon($sns->social_site_id) }}</a>
                    @endforeach
                </div>
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
            <div>
                @foreach ($snsAccounts as $sns)
                    <a href="{{ $sns->getUrl() }}" target="_blank">{{ sns_icon($sns->social_site_id) }}</a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 最小表示以外はメニューと内容を表示 -->
    <div class="d-none d-sm-block">
        <div class="d-flex flex-row">
            <div class="p-2" style="width: 300px;">
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}" class="nav-link @if($show == 'timeline') active @endif" aria-expanded="true">プロフィール</a>
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
                <a href="{{ route('ユーザーのタイムライン', ['showId' => $user->show_id]) }}">プロフィール</a>
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
            <div class="row mt-5 mb-5">
                <div class="col-6 text-center">
                    <a href="{{ route('ユーザー設定') }}" class="btn btn-sm btn-outline-dark mr-3"><i class="fas fa-cog"></i> 設定</a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('ログアウト') }}" class="btn btn-sm btn-warning">ログアウト</a>
                </div>
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