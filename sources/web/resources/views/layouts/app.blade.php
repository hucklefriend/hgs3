<!-- 通常ページ用テンプレート -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>β版</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @if (env('APP_DEBUG'))
    <link rel="stylesheet" href="{{ url2('css/hgs3.css') }}?ver={{ time() }}">
    @else
    <link rel="stylesheet" href="{{ url2('css/hgs3.css') }}">
    @endif

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <style>
        .dropdown:hover > .dropdown-menu {
            display: block;
        }
        .dropdown > .dropdown-toggle:active {
            /*Without this, clicking will make it sticky*/
            pointer-events: none;
        }
    </style>
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
                        <a class="dropdown-item" href="{{ url2('site') }}">サイト一覧</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCommunity" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        コミュニティ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownCommunity">
                        <a class="dropdown-item" href="{{ url2('game/soft') }}">ゲーム一覧</a>
                        <a class="dropdown-item" href="{{ url2('game/review') }}">レビュー</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <span class="navbar-text">
                @if (Auth::check())
                    <a class="nav-link" href="{{ url2('mypage') }}">マイページ</a>
                @else
                    <a class="nav-link" href="{{ url2('auth/login') }}">ログイン</a>
                @endif
            </span>
        </div>
    </nav>

</div>
<div class="container-fluid" style="padding-bottom: 20px;">
    @yield('content')
</div>

<footer class="footer">
    <div class="container-fluid">
        <div style="display:flex;">
            <div>
                <div class="d-none d-sm-none d-md-block">@yield('breadcrumb')</div>
            </div>
            <div style="margin-left: auto;font-size: 80%;">
                <a href="{{ route('サイトマップ') }}">サイトマップ</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
