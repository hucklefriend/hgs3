<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/hgs3.css') }}">

    <script src="{{ url('/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/popper.min.js') }}"></script>
    <script src="{{ url('/js/fontawesome-all.min.js') }}" defer></script>

</head>
<body>
<div class="fixed-top" id="header_menu">
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <span id="global_back_link">
            @yield('global_back_link')
        </span>
        <a class="navbar-brand" href="{{ route('トップ') }}">β版</a>
    </nav>
</div>
<div class="container-fluid" style="padding-bottom: 40px;" id="main_content">
    <h1>メンテナンス中です。</h1>
    <p class="ml-3">
        ただいまメンテナンス中です。<br>
        終了までしばらくお待ちください。
    </p>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="d-flex" style="height: 60px;padding-top:10px;">
            <div style="overflow: hidden;"></div>
            <div style="white-space: nowrap;" class="ml-auto">
                <a href="{{ route('サイトマップ') }}" class="align-self-center">サイトマップ</a>
            </div>
        </div>
        <div style="height: 40px;line-height: 40px;">
            &copy; yu-ki
            <a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</a>
            <a href="https://github.com/hucklefriend/hgs3" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</a>
            / since 2003.9.28
        </div>
    </div>
</footer>

</body>
</html>
