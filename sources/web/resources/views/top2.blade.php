<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>{{ env('APP_NAME') }} (RC)</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ url('/js/super_admin.min.js') }}"></script>

    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/super_admin.min.css') }}">
    @if (env('APP_ENV') != 'production')
        <link rel="stylesheet" href="{{ url('css/top.css') }}?ver={{ time() }}">
    @else
        <link rel="stylesheet" href="{{ url('css/top.css') }}?ver={{ env('SYSTEM_VERSION') }}">
    @endif

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
<body>
<main class="main">
</main>

@if (env('APP_ENV') != 'production')
    <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
@else
    <script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin></script>
@endif
</body>
</html>

