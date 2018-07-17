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
    <script src="{{ url('/js/NetworkLayout/childball.js') }}?ver={{ time() }}"></script>
    <script src="{{ url('/js/NetworkLayout/background.js') }}?ver={{ time() }}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>

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
<div id="network-layout">
    <canvas id="network-background"></canvas>
    <canvas id="network"></canvas>

    <div class="network-item" id="title">ホラーゲーム<br>ネットワーク</div>
    <div class="network-item" id="new-info">新着情報</div>
    <div class="network-item" id="notice">お知らせ</div>
    <div class="network-item" id="game">ゲーム</div>
    <div class="network-item" id="user">ユーザー</div>
    <div class="network-item" id="about"><a href="{{ route('当サイトについて') }}" class="network-layout-link" data-parent-id="about">当サイトについて</a></div>
    <div class="network-item" id="privacy-policy">プライバシー<br>ポリシー</div>
    <div class="network-item" id="site-map">サイトマップ</div>
</div>

<main id="main" class="closed">
    <section class="container">

        <div class="text-right"><button id="close-main" class="btn btn-secondary">×</button></div>
        <h1>当サイトについて</h1>


        <h4 class="card-title">{{ env('APP_NAME') }}とは</h4>
        <p>
            ホラーゲームのポータルサイトとして、ホラーゲームファン同士のつながりを作るサイトとなるべく開発を進めています。<br>
            個人運営ですので、いろいろと不備があると思いますが、温かい目で見守っていただければ幸いです。
        </p>
        <p>
            ユーザー登録して頂くと、ゲームのお気に入りを登録したり、ゲームのレビューを書いたり、ご自身のサイトを登録して紹介することができます。<br>
            また、攻略日記を書いたり、好きなゲームが近い人を探したり、二次創作・同人活動の紹介などといった機能を今後作っていきたいと考えています。
        </p>
        <p>
            外部サービスの機能を活用する方針なので、外部サービスでできることはそちらにお任せしようと思います。<br>
            例えば、当サイトにはユーザー同士のメッセージ交換機能はありません。<br>
            ユーザー同士で交流したいなという場合は、{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}Twitterや{{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }}facebookなどで行って頂ければと思います。<br>
        </p>


        <h4 class="card-title">ホラーゲームの基準</h4>
        <p>
            公式サイトなど開発・販売元もしくはハードウェアメーカーの情報や、SteamやAmazonなどのゲームを販売しているサイトの紹介文などでホラーゲームとして紹介されているゲームをホラーゲームとしています。<br>
            ゲーム情報サイトやWikipediaも参考にしてはいますが、たまにホラーゲームとして紹介されていても公式的に非ホラー扱いされていないものがありますので、そういうゲームは含めていません。<br>
            (デッドライジングや、DOOMなど)<br>
            怖さや面白さは基準になっていません。<br>
            たとえ怖くなくても、たとえ面白くなくても、たとえクソゲーオブザイヤーを獲得したとしても、ホラーゲームとして紹介されていれば当サイトで扱います。
        </p>


        <h4 class="card-title">メーカーについて</h4>
        <p>
            各ゲームのメーカーは「パブリッシャー(販売元)」を表示しています。<br>
            開発元ではありません。<br>
            例：「零～月蝕の仮面～」は開発はテクモですが販売は任天堂なので、任天堂として扱っています。
        </p>


        <h4 class="card-title">移植とリメイクについて</h4>
        <p>
            リメイクは別ゲームとして扱い、移植は同じゲームとして扱っています。<br>
            例：PS2の「零～紅い蝶～」とそのXBOXへの移植版「FATAL FRAME2 CRIMSON BUTTERFLY」は同じゲームですが、 WiiUのリメイク版「零～真紅の蝶～」は別ゲームです。<br>
            見た目の大きな改変があるものをリメイクとしています。<br>
            HD版は移植という考えです。
        </p>


        <h4 class="card-title">オープンソース</h4>
        <p>
            {{ env('APP_NAME') }}のソースコードをGitHubで公開しています。<br>
            <a href="https://github.com/hucklefriend/hgs3">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubリポジトリはこちら <i class="fas fa-sign-out-alt"></i></a>
        </p>
        <p>
            LAMP(Linux + Apache + MariaDB + PHP) と MongoDBを使って開発しています。<br>
            PHPのフレームワークにはLaravelを採用しています。
        </p>
        <p>
            バグの報告やご要望などありましたら、サイト内の「システムメッセージ」機能か、<a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}Twitter <i class="fas fa-sign-out-alt"></i></a>でご連絡をお願い致します。<br>
            <a href="https://github.com/hucklefriend/hgs3/issues" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubのIssues <i class="fas fa-sign-out-alt"></i></a>にIssueを登録して頂いても大丈夫です。<br>
            スパムメールがいっぱい来るようになったので、メールでのやりとりには対応しておりません。
        </p>


        <h4 class="card-title">その他</h4>
        <p>
            デザインテンプレートはこちらで購入したものを使っています。<br>
            <a href="https://wrapbootstrap.com/" target="_blank">WrapBootstrap <i class="fas fa-sign-out-alt"></i></a>
        </p>
        <p>
            バナー画像はこちらで購入したものを使っています。<br>
            <a href="https://rfclipart.com/" target="_blank">RF CLIPART <i class="fas fa-sign-out-alt"></i></a>
        </p>
        <p>
            こちらの画像をサイト内で利用しています。<br>
            <a href="http://icooon-mono.com/" target="_blank">ICOON MONO <i class="fas fa-sign-out-alt"></i></a>
        </p>
    </section>
</main>
<div id="canvas-cover"></div>
<script>
    let network = {
        main: {
            id: 'title',
            position: 'center',
            childNum: 4
        },
        children: [
            {
                id: 'new-info',
                position: {
                    offset: {
                        x: -100,
                        y: -200
                    }
                },
                childNum: 0
            },
            {
                id: 'notice',
                position: {
                    offset: {
                        x: 100,
                        y: 100
                    }
                },
                childNum: 0
            },
            {
                id: 'game',
                position: {
                    offset: {
                        x: 100,
                        y: -130
                    }
                },
                childNum: 3
            },
            {
                id: 'user',
                position: {
                    offset: {
                        x: -80,
                        y: -100
                    }
                },
                childNum: 2
            },
            {
                id: 'about',
                position: {
                    offset: {
                        x: 50,
                        y: -210
                    }
                },
                childNum: 0
            },
            {
                id: 'privacy-policy',
                position: {
                    offset: {
                        x: 70,
                        y: 200
                    }
                },
                childNum: 0
            },
            {
                id: 'site-map',
                position: {
                    offset: {
                        x: -70,
                        y: 120
                    }
                },
                childNum: 0
            },
        ]
    };

    let layout = new NetworkLayout(network);
    layout.start();
</script>
</body>
</html>
