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
        <p>金と申すものは、おもしろいものよ。つぎからつぎへ、さまざまな人びとの手にわたりながら、善悪二様のはたらきをする</p>

        @if ($isMyself)
            <a href="{{ url2('user/profile/edit') }}">プロフィール編集</a>
        @endif
    </div>

    <hr>

    <div class="d-none d-sm-block">
        <div class="d-flex flex-row">
            <div class="p-2">
                <div class="nav flex-column nav-pills">
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/timeline" class="nav-link @if($show == 'timeline') active @endif" aria-expanded="true">タイムライン</a>
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/follow" class="nav-link @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/follower" class="nav-link @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/favorite_game" class="nav-link @if($show == 'favorite_game') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteGameNum }}個</a>
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/site" class="nav-link @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/favorite_site" class="nav-link @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/diary" class="nav-link @if($show == 'diary') active @endif" aria-expanded="true">日記 {{ $diaryNum }}件</a>
                    <a href="{{ url2('user/profile') }}/{{ $user->id }}/community" class="nav-link @if($show == 'community') active @endif" aria-expanded="true">コミュニティ {{ $communityNum }}個</a>
                </div>
            </div>
            <div class="p-10">
                {{ $show }}
            </div>
        </div>
    </div>

    <div class="d-sm-none">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ url2('user/follow') }}/{{ $user->id }}">フォロー {{ $followNum }}人</a></li>
            <li class="list-group-item"><a href="{{ url2('user/follower') }}/{{ $user->id }}">フォロワー {{ $followerNum }}人</a></li>
            <li class="list-group-item"><a href="{{ url2('user/favorite_game') }}/{{ $user->id }}">お気に入りゲーム {{ $favoriteGameNum }}個</a></li>
            <li class="list-group-item"><a href="{{ url2('user/site') }}/{{ $user->id }}">サイト {{ $siteNum }}件</a></li>
            <li class="list-group-item"><a href="{{ url2('user/follower') }}/{{ $user->id }}">お気に入りサイト {{ $favoriteSiteNum }}件</a></li>
            <li class="list-group-item"><a href="{{ url2('user/follower') }}/{{ $user->id }}">日記 {{ $diaryNum }}件</a></li>
            <li class="list-group-item"><a href="{{ url2('user/communities') }}/{{ $user->id }}">コミュニティ {{ $communityNum }}個</a></li>
        </ul>
    </div>
@endsection