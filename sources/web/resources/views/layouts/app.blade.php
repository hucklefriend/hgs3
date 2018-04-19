<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title') {{ env('APP_NAME') }} (β)</title>

        <link rel="stylesheet" href="{{ url('css/super_admin.min.css') }}">
        @if (env('APP_DEBUG'))
            <link rel="stylesheet" href="{{ url('css/hgs3sa.css') }}?ver={{ time() }}">
        @else
            <link rel="stylesheet" href="{{ url('css/hgs3sa.css') }}?ver=20180519">
        @endif

        <script src="{{ url('/js/jquery-3.3.1.min.js') }}"></script>


        <script src="{{ url('/js/super_admin.min.js') }}"></script>
        <script src="{{ url('/js/popper.min.js') }}"></script>
        <script src="{{ url('/js/fontawesome-all.min.js') }}" defer></script>
        <script src="{{ url('/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ url('/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
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
                    <li class="hidden-xl-up">
                        <a href="{{ route('ゲーム一覧') }}">ゲーム</a>
                    </li>

                    <li class="hidden-xl-up">
                        <a href="{{ route('サイトトップ') }}">サイト</a>
                    </li>

                    @if (is_admin())
                        <li class="hidden-xl-up">
                            <a href="{{ route('管理メニュー') }}">管理メニュー</a>
                        </li>
                    @endif

                    @if (Auth::check())
                        <li class="hidden-xl-up">
                            <a href="{{ route('マイページ') }}">マイページ</a>
                        </li>
                    @else
                        <li class="hidden-xl-up">
                            <a href="{{ route('ログイン') }}">ログイン</a>
                        </li>
                    @endif
                </ul>
            </header>

            <div class="fixed-top" id="header_menu" style="display:none;">
                <nav class="navbar navbar-expand-sm navbar-light bg-light">
                    <span id="global_back_link">
                        @yield('global_back_link')
                    </span>
                    @if (env('APP_ENV') == 'staging')
                    <a class="navbar-brand" href="{{ route('トップ') }}">STG</a>
                    @else
                    <a class="navbar-brand" href="{{ route('トップ') }}">β版</a>
                    @endif
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ゲーム一覧') }}">ゲーム</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('サイトトップ') }}">サイト</a>
                            </li>
                            @if (is_admin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('管理メニュー') }}">管理メニュー</a>
                            </li>
                            @endif
                        </ul>
                        @if (Auth::check())
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('マイページ') }}">マイページ</a>
                            </li>
                        </ul>
                        @else
                            <span class="navbar-text">
                                <a class="nav-link" href="{{ route('ログイン') }}">ログイン</a>
                            </span>
                        @endif
                    </div>
                </nav>
            </div>

            <section class="content content--full">
                @yield('content')
            </section>

            <div class="container-fluid" style="padding-bottom: 40px;display:none;" id="main_content">
                @yield('content')
            </div>

            <footer class="footer">
        <div class="container-fluid">
            <div class="d-flex" style="height: 60px;padding-top:10px;">
                <div style="overflow: hidden;">@yield('breadcrumb')</div>
                <div style="white-space: nowrap;" class="ml-auto">
                    <a href="{{ route('サイトマップ') }}" class="align-self-center">サイトマップ</a>
                </div>
            </div>
            <div style="height: 40px;line-height: 40px;">
                &copy; yu-ki
                <a href="mailto:{{ env('ADMIN_MAIL') }}" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::MAIL) }}</a>
                <a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</a>
                <a href="https://github.com/hucklefriend/hgs3" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</a>
                / since 2003.9.28
            </div>
        </div>
    </footer>

            @yield('outsideContent')
        </main>
    </body>
</html>
