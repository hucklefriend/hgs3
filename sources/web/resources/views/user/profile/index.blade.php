@extends('layouts.app')

@section('content')
    <h4>@include('user.common.icon', ['u' => $user]){{ $user->name }}さんのプロフィール</h4>

    <div>
        @if (!$isMyself)
            @if ($isFollow)
                <form action="{{ url2('user/follow') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                    <span class="badge badge-success">フォロー中</span>
                    <button class="btn btn-danger btn-sm">解除</button>
                </form>
            @else
                <form action="{{ url2('user/follow') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                    <button class="btn btn-primary btn-sm">フォローする</button>
                </form>
            @endif
        @endif
    </div>

    <div>
        <p class="profile_text">{!! nl2br(e($user->profile)) !!}</p>

        @if ($isMyself)
            <div class="btn-group" role="group" aria-label="プロフィール">
                <a href="{{ url2('user/profile/change_icon') }}" class="btn btn-outline-dark">アイコン変更</a>
                <a href="{{ url2('user/profile/edit') }}" class="btn btn-outline-dark">プロフィール編集</a>
                <a href="{{ url2('user/profile/config') }}" class="btn btn-outline-dark">設定</a>
            </div>
            @if (is_admin())
            <a href="{{ url2('user/profile/config') }}" class="btn btn-outline-success">管理メニュー</a>
            @endif
            <a href="{{ url2('auth/logout') }}" class="btn btn-outline-danger" style="margin-left: 20px;">ログアウト</a>
        @endif
    </div>

    <hr>

    <!-- 最小表示以外はメニューと内容を表示 -->
    <div class="d-none d-sm-block">
        <div class="d-flex flex-row">
            <div class="p-2" style="width: 270px;">
                <div class="nav flex-column nav-pills">
                    <a href="{{ url2('user/profile/' . $user->id) }}/timeline" class="nav-link @if($show == 'timeline') active @endif" aria-expanded="true">タイムライン</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/follow" class="nav-link @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/follower" class="nav-link @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/favorite_soft" class="nav-link @if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteSoftNum }}個</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/review" class="nav-link @if($show == 'review') active @endif" aria-expanded="true">レビュー {{ $reviewNum }}件</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/site" class="nav-link @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/favorite_site" class="nav-link @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/diary" class="nav-link @if($show == 'diary') active @endif" aria-expanded="true">日記 {{ $diaryNum }}件</a>
                    <a href="{{ url2('user/profile/' . $user->id) }}/community" class="nav-link @if($show == 'community') active @endif" aria-expanded="true">コミュニティ {{ $communityNum }}個</a>
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
            <li class="list-group-item"><a href="{{ url2('user/timeline/') }}">タイムライン</a></li>
            <li class="list-group-item"><a href="{{ url2('user/follow/' . $user->id) }}">フォロー {{ $followNum }}人</a></li>
            <li class="list-group-item"><a href="{{ url2('user/follower/' . $user->id) }}">フォロワー {{ $followerNum }}人</a></li>
            <li class="list-group-item"><a href="{{ url2('user/favorite_soft/' . $user->id) }}">お気に入りゲーム {{ $favoriteSoftNum }}個</a></li>
            <li class="list-group-item"><a href="{{ url2('user/review/' . $user->id) }}">レビュー {{ $reviewNum }}件</a></li>
            <li class="list-group-item"><a href="{{ url2('user/site/' . $user->id) }}">サイト {{ $siteNum }}件</a></li>
            <li class="list-group-item"><a href="{{ url2('user/favorite_site/' . $user->id) }}">お気に入りサイト {{ $favoriteSiteNum }}件</a></li>
            <li class="list-group-item"><a href="{{ url2('user/diary/' . $user->id) }}">日記 {{ $diaryNum }}件</a></li>
            <li class="list-group-item"><a href="{{ url2('user/communities/' . $user->id) }}">コミュニティ {{ $communityNum }}個</a></li>
        </ul>
    </div>
@endsection