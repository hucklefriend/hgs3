<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <base href="/haribote/">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="stylesheet" href="{{ url('css/network.css') }}?{{ time() }}">
    <script src="{{ url('js/network.js') }}?{{ time() }}"></script>
    <script
            src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
            integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
            crossorigin="anonymous"></script>
    <script>
        let network = null;

        $(()=>{
            network = new Network();
            network.draw();
        });
    </script>
</head>
<body>
<div class="cntr">
    <main>
    @yield('content')
        <script>
            $('.cntr').scrollTop(50);
        </script>
        <footer>&nbsp;</footer>
    </main>
</div>
<canvas id="network-background-canvas" width="1000" height="1000"></canvas>

</body>
</html>
