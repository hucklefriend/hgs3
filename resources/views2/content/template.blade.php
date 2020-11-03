<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    @if (strlen($title) > 0)
    <title>{{ $title }} | {{ env('APP_NAME') }}</title>
    @else
    <title>{{ env('APP_NAME') }}</title>
    @endif

    {{-- <link rel="preload" as="style" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" onload="this.rel='stylesheet'"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/top.css') }}?ver={{ time() }}">
</head>
<body>

<main id="main" style="display:none;">
    <section class="container">
        <div class="text-right"><button id="close-main" class="btn btn-secondary">×</button></div>
        <div id="content">@include('content.' . $viewFileName, $viewData ?? [])</div>
    </section>
</main>

<div id="network-background" style="display:none;">
    <canvas id="network-background-canvas" width="1000px" height="1000px"></canvas>
    <canvas id="network-image-canvas" width="1000px" height="1000px"></canvas>
</div>

<div id="network-items" style="display:none;"></div>
<div id="canvas-cover" style="display:none;"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/superagent/3.8.3/superagent.min.js"></script>
<script src="{{ url('/js/network/network.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/item.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/childball.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/image.js') }}?ver={{ time() }}"></script>
<script src="{{ url('/js/network/background.js') }}?ver={{ time() }}"></script>
<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
<script>
    let layout = new NetworkLayout({!! json_encode($network) !!});
    layout.startContent();
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
