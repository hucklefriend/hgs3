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
                @if ($followStatus != 0)
                <div class="mt-2">
                    @if ($followStatus == 2)
                        <form method="POST" action="{{ route('フォロー登録') }}">
                            {{ csrf_field() }}
                            <button class="btn btn-sm btn-outline-info"><small>フォローする</small></button>
                            <input type="hidden" name="follow_user_id" value="{{ $user->show_id }}">
                        </form>
                    @elseif ($followStatus == 1)
                        <form method="POST" action="{{ route('フォロー解除') }}" onsubmit="return confirm('{{ $user->name }}さんのフォローを解除します。');">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-sm btn-outline-warning"><small>フォロー解除</small></button>
                            <input type="hidden" name="follow_user_id" value="{{ $user->show_id }}">
                        </form>
                    @endif
                </div>
                @endif
            </header>
        @endif

        <style>
            .swiper-slide {
                width: 120px;
                margin: 10px;
                text-align: center;
            }

            .swiper-slide a {
                padding: 10px 0;
                display: block;
            }
            .swiper-slide a.active {
                background-color: rgba(255, 255, 255, 0.1);
            }
        </style>

        <div class="swiper-container mb-3 hidden-sm-up" id="profile_slide_menu">
            <div class="swiper-wrapper">
                @if ($open)
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'profile']) }}" class="@if($show == 'profile') active @endif" aria-expanded="true">プロフィール</a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}" class="@if($show == 'timeline') active @endif" aria-expanded="true">タイムライン</a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}" class="@if($show == 'follow') active @endif" aria-expanded="true">フォロー</a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}" class="@if($show == 'follower') active @endif" aria-expanded="true">フォロワー</a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}" class="@if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム</a>
                </div>
                @endif
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}" class="@if($show == 'review') active @endif" aria-expanded="true">レビュー</a>
                </div>
            @if ($isMyself)
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review_draft']) }}" class="@if($show == 'review_draft') active @endif" aria-expanded="true">レビューの下書き</a>
                </div>
            @endif
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}" class="@if($show == 'site') active @endif" aria-expanded="true">サイト</a>
                </div>
                @if ($open)
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}" class="@if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト</a>
                </div>
                @endif
                @if ($isMyself)
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'good_site']) }}" class="@if($show == 'good_site') active @endif" aria-expanded="true">いいねしたサイト</a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'message']) }}" class="@if($show == 'message') active @endif" aria-expanded="true">システムメッセージ</a>
                </div>
                @endif
            </div>
            <div class="swiper-scrollbar"></div>
        </div>
            <script>
                let swiper = null;
                $(function(){
                    let startIndex = 0;
                    $('.swiper-slide a').each(function (){
                        if ($(this).hasClass('active')) {
                            return false;
                        }

                        startIndex++;
                    });

                    swiper = new Swiper('#profile_slide_menu', {
                        slidesPerView: 'auto',
                        initialSlide: startIndex,
                        spaceBetween: 0,
                        scrollbar: {
                            el: '.swiper-scrollbar',
                            hide: false
                        },
                        freeMode: true,
                    });
                });
            </script>



        <div class="d-flex flex-row">
            <div class="p-2 hidden-xs-down" style="width: 300px;">
                <div class="nav flex-column nav-pills">
                    @if ($open)
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'profile']) }}" class="nav-link @if($show == 'profile') active @endif" aria-expanded="true">プロフィール</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'timeline']) }}" class="nav-link @if($show == 'timeline') active @endif" aria-expanded="true">タイムライン</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follow']) }}" class="nav-link @if($show == 'follow') active @endif" aria-expanded="true">フォロー {{ $followNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'follower']) }}" class="nav-link @if($show == 'follower') active @endif" aria-expanded="true">フォロワー {{ $followerNum }}人</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_soft']) }}" class="nav-link @if($show == 'favorite_soft') active @endif" aria-expanded="true">お気に入りゲーム {{ $favoriteSoftNum }}個</a>
                    @endif
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review']) }}" class="nav-link @if($show == 'review') active @endif" aria-expanded="true">レビュー {{ $reviewNum }}件</a>

                    @if ($isMyself)
                        <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'review_draft']) }}" class="nav-link @if($show == 'review_draft') active @endif" aria-expanded="true">レビューの下書き {{ $reviewDraftNum }}件</a>
                    @endif
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'site']) }}" class="nav-link @if($show == 'site') active @endif" aria-expanded="true">サイト {{ $siteNum }}件</a>
                    @if ($open)
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'favorite_site']) }}" class="nav-link @if($show == 'favorite_site') active @endif" aria-expanded="true">お気に入りサイト {{ $favoriteSiteNum }}件</a>
                    @endif
                    @if ($isMyself)
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'good_site']) }}" class="nav-link @if($show == 'good_site') active @endif" aria-expanded="true">いいねしたサイト {{ $goodSiteNum }}件</a>
                    <a href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'message']) }}" class="nav-link @if($show == 'message') active @endif" aria-expanded="true">システムメッセージ {{ $messageNum }}件</a>
                    @endif
                </div>
            </div>
            <div style="width: 100%;">
                @include('user.profile.parts.' . Illuminate\Support\Str::camel($show), $parts)
            </div>
        </div>

        @if ($isMyself)
            <div class="hidden-sm-up" style="margin-top: 5rem;">
                <hr>
                <div>
                    <div class="d-flex align-content-around">
                        <div><a href="{{ route('ユーザー設定') }}" class="btn"><i class="fas fa-cog"></i> 設定</a></div>
                        <div class="ml-auto text-right"><a href="{{ route('ログアウト') }}" class="btn btn-outline-warning" onclick="return confirm('ログアウトしていいですか？');">ログアウト</a></div>
                    </div>
                </div>
            </div>
        @endif


            @if (is_admin())
                <div class="card mt-5">
                    <div class="card-body">
                        <h4 class="card-title">管理人用メニュー</h4>

                        <a href="{{ route('管理人メッセージ入力', ['user' => $user->id, 'redId' => 0]) }}" class="and-more mb-4 mr-4">メッセージを送る</a>
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
