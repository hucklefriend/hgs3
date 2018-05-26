<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        @if (View::hasSection('title'))
        <title>@yield('title') | {{ env('APP_NAME') }} (β)</title>
        @else
        <title>{{ env('APP_NAME') }} (β)</title>
        @endif

        <link rel="stylesheet" href="{{ url('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}">
        <link rel="stylesheet" href="{{ url('vendors/bower_components/animate.css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ url('vendors/bower_components/select2/dist/css/select2.min.css') }}">
        <link href="https://fonts.googleapis.com/earlyaccess/sawarabimincho.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.6/css/swiper.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ url('css/super_admin.min.css') }}">
        @if (env('APP_ENV') != 'production')
            <link rel="stylesheet" href="{{ url('css/hgs3sa.css') }}?ver={{ time() }}">
        @else
            <link rel="stylesheet" href="{{ url('css/hgs3sa.css') }}?ver=20180519">
        @endif

        <script src="https://cdnjs.cloudflare.com/ajax/libs/layzr.js/2.2.2/layzr.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.6/js/swiper.min.js"></script>
        <script src="{{ url('/js/fontawesome-all.min.js') }}" defer></script>
        <script src="{{ url('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ url('/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ url('/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ url('/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
        <script src="{{ url('vendors/bower_components/autosize/dist/autosize.min.js') }}"></script>
        <script src="{{ url('vendors/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ url('/js/super_admin.min.js') }}"></script>
        <script src="{{ url('/js/common.js') }}"></script>

        @yield('head_append')

        @if (env('APP_ENV') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114831632-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-114831632-1');
        </script>
        @endif
    </head>
    <body data-sa-theme="4">
        <main class="main">
            <div class="page-loader">
                <div class="page-loader__spinner">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>

            <header class="header">
                <div class="global-link">
                    @if (View::hasSection('global_back_link'))
                        <a href="@yield('global_back_link')" class="d-flex justify-content-center">
                            <i class="fas fa-angle-left align-self-center"></i>
                        </a>
                    @endif
                </div>

                <div class="logo">
                    @if (env('APP_ENV') == 'staging')
                    <h1><a href="{{ route('トップ') }}">STG</a></h1>
                    @else
                    <h1><a href="{{ route('トップ') }}">β版</a></h1>
                    @endif
                </div>

                <ul class="top-nav">

                    <li class="hidden-xs-down">
                        <a href="{{ route('ゲーム一覧') }}">ゲーム</a>
                    </li>

                    <li class="hidden-xs-down">
                        <a href="{{ route('サイトトップ') }}">サイト</a>
                    </li>

                    @if (is_admin())
                        <li class="hidden-xs-down">
                            <a href="{{ route('管理メニュー') }}">管理</a>
                        </li>
                    @endif

                    @if (Auth::check())
                        <li class="hidden-xs-down">
                            <a href="{{ route('マイページ') }}">マイページ</a>
                        </li>
                    @else
                        <li class="hidden-xs-down">
                            <a href="{{ route('ログイン') }}">ログイン</a>
                        </li>
                    @endif

                    <li class="dropdown hidden-sm-up">
                        <a href="#" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i></a>

                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-112px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a href="{{ route('ゲーム一覧') }}" class="dropdown-item">ゲーム</a>
                            <a href="{{ route('サイトトップ') }}" class="dropdown-item">サイト</a>
                            @if (Auth::check())
                                @if (is_admin())
                                    <a href="{{ route('管理メニュー') }}" class="dropdown-item">管理メニュー</a>
                                @endif
                            <a href="{{ route('マイページ') }}" class="dropdown-item">マイページ</a>
                            @else
                            <a href="{{ route('ログイン') }}" class="dropdown-item">ログイン</a>
                            @endif
                        </div>
                    </li>

                </ul>
            </header>

            <section class="content content--full">
                @yield('content')
            </section>

            <footer class="footer">
                <div style="overflow: hidden" class="mb-2">@yield('breadcrumb')</div>
                <div style="white-space: nowrap;" class="text-right">
                    <a href="{{ route('プライバシーポリシー') }}" class="align-self-center">プライバシーポリシー</a>
                    <span class="mx-2">・</span>
                    <a href="{{ route('サイトマップ') }}" class="align-self-center">サイトマップ</a>
                </div>
                <div style="height: 40px;line-height: 40px;">
                    &copy; yu-ki
                    <a href="mailto:{{ env('ADMIN_MAIL') }}" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::MAIL) }}</a>
                    <a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</a>
                    <a href="https://github.com/hucklefriend/hgs3" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</a>
                    / since 2003.9.28
                </div>
                <div class="my-2">


                </div>
            </footer>

            @yield('outsideContent')
        </main>
    <script>
        const lazyLoader = Layzr({
            normal: 'data-normal'
        });

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function(){$(".page-loader").fadeOut()},500);
            lazyLoader
                .update()           // track initial elements
                .check()            // check initial elements
                .handlers(true);    // bind scroll and resize handlers
        });

        $(window).on('beforeunload', function(e) {
            $('.page-loader__spinner').hide();
            $('.page-loader').fadeIn();
        });

    </script>
    </body>
</html>
