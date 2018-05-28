@extends('layouts.app')

@section('title')当サイトについて@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ env('APP_NAME') }}について</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ env('APP_NAME') }}とは</h4>

                <p>
                    ホラーゲームのポータルサイトとして開発を進めています。<br>
                    ホラーゲームに関するサイトを集めて、ホラーゲームファン同士のつながりを作っていけたらいいなと思っています。<br>
                    外部のサイトの機能を活用する方針なので、外部サイトでできることは外部サイトにお任せしようと思います。<br>
                    例えば、当サイトにはユーザー同士のメッセージ交換機能はありません。<br>
                    同じホラーゲームが好きなユーザーを見かけたので交流したいなという場合は、{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}Twitterや{{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }}facebookなどで行って頂ければと思います。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ホラーゲームの基準</h4>

                <p>
                    公式サイトなど開発・販売元からの情報や、SteamやAmazonなどのゲームを販売しているサイトの紹介文などでホラーゲームとして紹介されているゲームをホラーゲームとしています。<br>
                    ゲーム情報サイトやWikipediaも参考にしてはいますが、たまにホラーゲームとして紹介されていても、公式のサイトにはそのような記載がないただのアクションゲーム扱いされているものもありますので、そういうゲームは含めていません。<br>
                    (デッドライジングや、DOOMシリーズなど)<br>
                    怖さや面白さは基準になっていません。<br>
                    たとえ怖くなくても、たとえ面白くなくても、たとえクソゲーオブザイヤーを獲得したとしても、ホラーゲームとして紹介されていれば当サイトで扱います。<br>
                    オカルトや伝奇、猟奇的な内容ではホラーゲームとして扱っていません。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">メーカーについて</h4>

                <p>
                    各ゲームのメーカーは「パブリッシャー(販売元)」を表示しています。<br>
                    開発元ではありません。<br>
                    例：「零～月蝕の仮面～」は開発はテクモですが販売は任天堂なので、任天堂として扱っています。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">移植とリメイクについて</h4>

                <p>
                    リメイクは別ゲームとして扱い、移植は同じゲームとして扱っています。<br>
                    例：PS2の「零～紅い蝶～」とそのXBOXへの移植版「FATAL FRAME2 CRIMSON BUTTERFLY」は同じゲームですが、 WiiUのリメイク版「零～真紅の蝶～」は別ゲームです。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">オープンソース</h4>

                <p>
                    {{ env('APP_NAME') }}のソースコードをGitHubで公開しています。<br>
                    LAMP+MongoDBで開発をしてます。<br>
                    PHPのフレームワークにはLaravelを使っています。<br>
                    <a href="https://github.com/hucklefriend/hgs3">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubリポジトリはこちら</a>
                </p>
                <p>
                    バグの報告やご要望などありましたら、<a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}Twitter</a>か<a href="mailto:webmaster@horrorgame.net">メール</a>でご連絡をお願い致します。<br>
                    {{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubのIssuesにIssueを登録して頂いても大丈夫です。
                </p>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイトマップ</li>
        </ol>
    </nav>
@endsection