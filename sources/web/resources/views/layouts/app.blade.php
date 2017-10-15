<!-- α版用テンプレート -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>α版</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @if (env('APP_DEBUG'))
    <link rel="stylesheet" href="{{ url2('css/hgs3.css') }}?ver={{ time() }}">
    @else
    <link rel="stylesheet" href="{{ url2('css/hgs3.css') }}">
    @endif

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</head>
<body>
<div class="fixed-top">
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="{{ url2('') }}">α版</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item @if ($navActive == 'home') active @endif">
                    @if (Auth::check())
                        <a class="nav-link" href="{{ url2('mypage') }}">マイページ</a>
                    @else
                        <a class="nav-link" href="{{ url2('/') }}">トップページ</a>
                    @endif
                </li>
                <li class="nav-item @if ($navActive == 'game') active @endif">
                    <a class="nav-link" href="{{ url2('game') }}">ゲーム一覧</a>
                </li>
                <li class="nav-item @if ($navActive == 'review') active @endif">
                    <a class="nav-link" href="{{ url2('review') }}">レビュー</a>
                </li>
                <li class="nav-item @if ($navActive == 'site') active @endif">
                    <a class="nav-link" href="{{ url2('site') }}">サイト</a>
                </li>
                <li class="nav-item @if ($navActive == 'diary') active @endif">
                    <a class="nav-link" href="{{ url2('diary') }}">日記</a>
                </li>
                <li class="nav-item @if ($navActive == 'community') active @endif">
                    <a class="nav-link" href="{{ url2('community') }}">コミュニティ</a>
                </li>
            </ul>
            <span class="navbar-text">
                @if (Auth::check())
                    <a class="nav-link" href="{{ url2('auth/logout') }}">ログアウト</a>
                @else
                    <a class="nav-link" href="{{ url2('auth/login') }}">ログイン</a>
                @endif
            </span>
        </div>
    </nav>

</div>
<div class="container-fluid">
    @yield('content')
</div>

<footer class="footer">
    <div class="container-fluid">
        <div style="display:flex;">
            <div>
                webmaster:yu-ki
                <a href="mailto:webmaster@horrogame.net" style="text-decoration: none;">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                </a>
                <a href="https://twitter.com/huckle_friend" style="color: #55acee;text-decoration: none;">
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
            </div>
            <div style="margin-left: auto;font-size: 80%;">
                <a href="{{ url2('sitemap') }}">サイトマップ</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
