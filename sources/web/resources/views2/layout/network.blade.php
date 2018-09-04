<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    @if (strlen($title) > 0)
    <title>{{ $title }} | {{ env('APP_NAME') }}</title>
    @else
    <title>{{ env('APP_NAME') }}</title>
    @endif

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/top.css') }}?ver={{ time() }}">
</head>
<body>

    <div id="network-area">
        <div id="network-background">
            <canvas id="network-background-canvas" width="1000px" height="1000px"></canvas>
            <canvas id="network-image-canvas" width="1000px" height="1000px"></canvas>
        </div>

        <div id="network-items"></div>
    </div>

    <main id="main" class="closed">
        <section class="container">
            <div id="content-loading" class="text-center"><img src="{{ url('img/loading.gif') }}"></div>

            <div id="content-area">
                <div id="content"></div>
                <div class="content-footer">
                    <div class="text-center"><button id="close-main" class="btn btn-secondary">閉じる</button></div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/superagent/3.8.3/superagent.min.js"></script>
    <script src="{{ url('/js/network/network.js') }}?ver={{ time() }}"></script>
    <script src="{{ url('/js/network/itemManager.js') }}?ver={{ time() }}"></script>
    <script src="{{ url('/js/network/item.js') }}?ver={{ time() }}"></script>
    <script src="{{ url('/js/network/image.js') }}?ver={{ time() }}"></script>
    <script src="{{ url('/js/network/background.js') }}?ver={{ time() }}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script>
        let network = new Network({!! json_encode($network) !!});
        network.start();
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
