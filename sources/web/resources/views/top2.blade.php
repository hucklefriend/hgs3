<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>{{ env('APP_NAME') }} 真トップ</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ url('css/top.css') }}?ver={{ time() }}">
    <script src="{{ url('/js/NetworkLayout/layout.js') }}?ver={{ time() }}"></script>
    <script src="{{ url('/js/NetworkLayout/item.js') }}?ver={{ time() }}"></script>

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
<main>
    <canvas id="network"></canvas>

    <div class="network-item" id="title">ホラーゲーム<br>ネットワーク</div>
    <div class="network-item" id="link1">新着情報</div>
    <div class="network-item" id="link2">お知らせ</div>
    <div class="network-item" id="link3">Games</div>
    <div class="network-item" id="link4">Reviews</div>
    <div class="network-item" id="link5">Friends</div>
    <div class="network-item" id="link6">Sites</div>
</main>

<div id="canvas-cover"></div>
<script>
    let layout = new NetworkLayout();
    layout.addItem('title', [], {position: 'center'});
    layout.addItem('link1', ['title']);
    layout.addItem('link2', ['title']);
    layout.addItem('link3', ['title']);
    layout.addItem('link4', ['title']);
    layout.addItem('link5', ['title']);
    layout.addItem('link6', ['title']);

    layout.start();
</script>
</body>
</html>
