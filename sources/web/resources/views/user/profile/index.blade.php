@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}">&lt;</a>
@endsection

@section('content')
    <h1>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのページ</h1>

    <div>
        @if (!$isMyself)
            @if ($isFollow)
                <form action="{{ route('フォロー登録') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                    <span class="badge badge-success">フォロー中</span>
                    <button class="btn btn-danger btn-sm">解除</button>
                </form>
            @else
                <form action="{{ route('フォロー解除') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                    <button class="btn btn-primary btn-sm">フォローする</button>
                </form>
            @endif
        @endif
    </div>

    @if (!empty($user->profile))
    <div style="max-height: 3rem;overflow-y: scroll;">
        <p class="profile_text">{!! nl2br(e($user->profile)) !!}</p>
    </div>
    @endif

    <div class="d-none d-sm-block">

        @if ($isMyself)
            <div class="btn-group" role="group" aria-label="プロフィール">
                <a href="{{ route('アイコン変更') }}" class="btn btn-outline-dark">アイコン変更</a>
                <a href="{{ route('プロフィール編集') }}" class="btn btn-outline-dark">プロフィール編集</a>
                <a href="{{ route('コンフィグ') }}" class="btn btn-outline-dark">設定</a>
            </div>
        @endif
    </div>

    <hr class="d-none d-sm-block">

    <!-- 最小表示以外はメニューと内容を表示 -->
    <div class="d-none d-sm-block">
        <div class="d-flex flex-row">
            <div class="p-2" style="width: 270px;">
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}" class="nav-link @if($show == 'timeline') active @endif" aria-expanded="true">タイムライン</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}" class="nav-link @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}" class="nav-link @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}" class="nav-link @if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteSoftNum }}個</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}" class="nav-link @if($show == 'review') active @endif" aria-expanded="true">レビュー {{ $reviewNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}" class="nav-link @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}" class="nav-link @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'diary']) }}" class="nav-link @if($show == 'diary') active @endif" aria-expanded="true">日記 {{ $diaryNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'community']) }}" class="nav-link @if($show == 'community') active @endif" aria-expanded="true">コミュニティ {{ $communityNum }}個</a>
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
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーの日記', ['showId' => $user->show_id]) }}">日記</a>
                <span class="badge badge-secondary">{{ $diaryNum }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('ユーザーのコミュニティ', ['showId' => $user->show_id]) }}">コミュニティ {{ $communityNum }}個</a>
                <span class="badge badge-secondary">{{ $communityNum }}</span>
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
        @endif

    </div>
@endsection


@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            @if ($isMyself)
                <li class="breadcrumb-item active" aria-current="page">マイページ</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">ユーザーページ</li>
            @endif
        </ol>
    </nav>
@endsection