@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::userGroup($pageId) }}@endsection

@section('content')
    <div class="content__inner">

        @if ($isMyself)
            <div class="d-sm-flex">
                <header class="content__title">
                    <h1>
                        @include('user.common.icon', ['u' => $user])
                        <span class="align-middle">{{ $user->name }}さん</span>
                    </h1>
                </header>
                <div class="ml-auto text-right hidden-xs-down">
                    <a href="{{ route('ユーザー設定') }}" class="btn btn-sm btn-outline-dark mr-3"><i class="fas fa-cog"></i> 設定</a>
                    <a href="{{ route('ログアウト') }}" class="btn btn-sm btn-outline-warning" onclick="return confirm('ログアウトしていいですか？');">ログアウト</a>
                </div>
            </div>
        @else
            <header class="content__title">
                <h1>
                    @include('user.common.icon', ['u' => $user])
                    <span class="align-middle">{{ $user->name }}さん</span>
                </h1>
            </header>
        @endif

        <div class="d-flex flex-row">
            <div class="p-2 hidden-xs-down" style="width: 300px;">
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'profile']) }}" class="nav-link @if($show == 'profile') active @endif" aria-expanded="true">プロフィール</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}" class="nav-link @if($show == 'timeline') active @endif" aria-expanded="true">タイムライン</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}" class="nav-link @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}" class="nav-link @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}" class="nav-link @if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteSoftNum }}個</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}" class="nav-link @if($show == 'review') active @endif" aria-expanded="true">レビュー {{ $reviewNum }}件</a>

                    @if ($isMyself)
                        <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review_draft']) }}" class="nav-link @if($show == 'review_draft') active @endif" aria-expanded="true">レビューの下書き {{ $reviewDraftNum }}件</a>
                    @endif
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}" class="nav-link @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}" class="nav-link @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>

                    @if ($isMyself)
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'good_site']) }}" class="nav-link @if($show == 'good_site') active @endif" aria-expanded="true">いいねしたサイト {{ $goodSiteNum }}件</a>
                    @endif
                </div>
            </div>
            <div style="width: 100%;">
                <div class="hidden-sm-up mb-5">
                    <div class="card">
                        <div class="card-body">
                            <label for="small_menu"><small>プロフィールメニュー</small></label>
                            <div class="form-group">
                                <select class="select2" data-minimum-results-for-search="Infinity" id="small_menu">
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'profile']) }}"{{ selected($show, 'profile') }}>プロフィール</option>
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}"{{ selected($show, 'timeline') }}>タイムライン</option>
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}"{{ selected($show, 'follow') }}>フォロー</option>
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}"{{ selected($show, 'follower') }}>フォロワー</option>
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}"{{ selected($show, 'favorite_soft') }}>お気に入りゲーム</option>
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}"{{ selected($show, 'review') }}>レビュー</option>
                                    @if ($isMyself)
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review_draft']) }}"{{ selected($show, 'review_draft') }}>レビューの下書き</option>
                                    @endif
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}"{{ selected($show, 'site') }}>サイト</option>
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}"{{ selected($show, 'favorite_site') }}>お気に入りサイト</option>
                                    @if ($isMyself)
                                    <option data-url="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'good_site']) }}"{{ selected($show, 'good_site') }}>いいねしたサイト</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                @include('user.profile.parts.' . camel_case($show), $parts)
            </div>
        </div>

        @if ($isMyself)
            <div class="hidden-sm-up" style="margin-top: 5rem;">
                <hr>
                <div>
                    <div class="d-flex align-content-around">
                        <div>
                            <a href="{{ route('ユーザー設定') }}" class="btn"><i class="fas fa-cog"></i> 設定</a>
                        </div>
                        <div class="ml-auto text-right">
                            <a href="{{ route('ログアウト') }}" class="btn btn-outline-warning" onclick="return confirm('ログアウトしていいですか？');">ログアウト</a>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        $(function (){
            $('#small_menu').on('change', function (){
                let selected = $('#small_menu option:selected');
                location.href = selected.data('url');
            });
        });
    </script>

@endsection
