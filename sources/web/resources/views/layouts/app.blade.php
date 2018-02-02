<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>H.G.N. -Horror Game Network- (β)</title>

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    @if (env('APP_DEBUG'))
    <link rel="stylesheet" href="{{ url('css/hgs3.css') }}?ver={{ time() }}">
    @else
    <link rel="stylesheet" href="{{ url('css/hgs3.css') }}">
    @endif

    <script src="{{ url('/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/popper.min.js') }}"></script>
    <script src="{{ url('/js/fontawesome-all.min.js') }}" defer></script>

    @if (isset($useChart) && $useChart)
    <script src="{{ url('/js/Chart.bundle.min.js') }}"></script>
    <script src="{{ url('/js/Chart.min.js') }}"></script>
    @endif
</head>
<body>
<div class="fixed-top">
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <span id="global_back_link">
            @yield('global_back_link')
        </span>
        <a class="navbar-brand" href="{{ route('トップ') }}">β版</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownGame" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ゲーム
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownGame">
                        <a class="dropdown-item" href="{{ route('ゲーム一覧') }}">ゲーム一覧</a>
                        <a class="dropdown-item" href="{{ route('レビュートップ') }}">レビュー</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSite" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        サイト
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownSite">
                        <a class="dropdown-item" href="{{ route('サイトトップ') }}">サイト一覧</a>
                    </div>
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
<div class="container-fluid" style="padding-bottom: 40px;">
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
            since 2003.9.28
        </div>
    </div>
</footer>

</body>
</html>
