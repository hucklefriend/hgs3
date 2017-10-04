<!-- α版用テンプレート -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>α版</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @if (env('APP_DEBUG'))
    <link rel="stylesheet" href="{{ url2('css/hgs3.css') }}?ver={{ time() }}">
    @else
    <link rel="stylesheet" href="{{ url2('css/hgs3.css') }}">
    @endif
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>
<div class="fixed-top">
    <nav class="navbar navbar-toggleable-sm navbar-light bg-faded">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="{{ url2('') }}">α版</a>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item @if ($navActive == 'home') active @endif">
                    @if (Auth::check())
                        <a class="nav-link" href="{{ url2('mypage') }}">マイページ</a>
                    @else
                        <a class="nav-link" href="{{ url2('') }}">トップページ</a>
                    @endif
                </li>
                <li class="nav-item @if ($navActive == 'game') active @endif">
                    <a class="nav-link" href="{{ url2('game/soft') }}">ゲーム一覧</a>
                </li>
                <li class="nav-item @if ($navActive == 'review') active @endif">
                    <a class="nav-link" href="{{ url2('game/review') }}">レビュー</a>
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
            <ul class="navbar-nav my-2 my-lg-0">
                @if (Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ url2('auth/logout') }}">ログアウト</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url2('auth/login') }}">ログイン</a>
                </li>
                @endif
            </ul>
        </div>
    </nav>

</div>
<div class="container-fluid">
    @yield('content')
</div>

<footer class="footer">
    <div class="container">
        webmaster:yu-ki
        <a href="mailto:webmaster@horrogame.net" style="text-decoration: none;">
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
        </a>
        <a href="https://twitter.com/huckle_friend" style="color: #55acee;text-decoration: none;">
            <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
    </div>
</footer>

</body>
</html>
