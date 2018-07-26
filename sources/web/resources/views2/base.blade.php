<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>{{ env('APP_NAME') }} トップ</title>

    {{-- <link rel="preload" as="style" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" onload="this.rel='stylesheet'"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/top.css') }}?ver={{ time() }}">
</head>
<body>

<main id="main" class="closed">
    <section class="container">
        <div class="text-right"><button id="close-main" class="btn btn-secondary">×</button></div>
        <div id="content"></div>
    </section>
</main>

<div id="network-background">
    <canvas id="network-background-canvas" width="1000px" height="1000px"></canvas>
    <canvas id="network-image-canvas" width="1000px" height="1000px"></canvas>
</div>

<div id="network-items">
    <div class="network-item" id="title">ホラーゲーム<br>ネットワーク</div>
    <div class="network-item" id="new-info">新着情報</div>
    <div class="network-item" id="notice">お知らせ</div>
    <div class="network-item" id="game"><a href="{{ route('ゲーム一覧') }}" class="network-change-main" data-parent-id="game">ゲーム</a></div>
    <div class="network-item" id="user">ユーザー</div>
    <div class="network-item" id="about"><a href="{{ route('当サイトについて') }}" class="network-open-main" data-parent-id="about">当サイトについて</a></div>
    <div class="network-item" id="privacy-policy">プライバシー<br>ポリシー</div>
    <div class="network-item" id="site-map">サイトマップ</div>
</div>

<div id="canvas-cover" style="display:none;"></div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/superagent/3.8.3/superagent.min.js"></script>
<script src="{{ url('/js/network/layout.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/item.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/childball.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/image.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/background.js') }}?ver={{ time() }}"></script>
<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>

<script>
    let network = {{ json_encode($networkLayout) }};

    let layout = new NetworkLayout(network);
    layout.start();
</script>

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

</body>
</html>
