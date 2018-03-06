@extends('layouts.app')

@section('title')当サイトについて | @endsection

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>{{ env('APP_NAME') }}について</h1>

    <section class="my-4">
        <h2>{{ env('APP_NAME') }}とは</h2>
        <p class="ml-3">
            ホラーゲームのポータルサイトとして開発を進めています。<br>
            ホラーゲームに関するサイトを集めて、ホラーゲームファン同士のつながりを作っていけたらいいなと思っています。<br>
            外部のサイトの機能を活用する方針なので、外部サイトでできることは外部サイトにお任せしようと思います。<br>
            例えば、当サイトにはユーザー同士のメッセージ交換機能はありません。<br>
            同じホラーゲームが好きなユーザーを見かけたので交流したいなという場合は、Twitterやfacebookなどで行って頂ければと思います。
        </p>
    </section>

    <section class="my-5">
        <h2>ホラーゲームの基準</h2>
        <p class="ml-3">
            公式サイトなど開発・販売元からの情報や、SteamやAmazonなどのゲームを販売しているサイトの紹介文、4gamerやファミ通などのゲーム情報サイト、Wikipediaの情報などでホラーゲームとして紹介されているゲームをホラーゲームとしています。<br>
            怖さや面白さは基準になっていません。<br>
            たとえ怖くなくても、たとえ面白くなくても、たとえクソゲーオブザイヤーを獲得したとしても、ホラーゲームとして紹介されていれば当サイトで扱います。<br>
            オカルトや伝奇のみではホラーゲームとして扱っていません。
        </p>
    </section>

    <section class="my-5">
        <h2>オープンソース</h2>
        <p class="ml-3">
            {{ env('APP_NAME') }}のソースコードをGitHubで公開しています。<br>
            LAMP+MongoDBで開発をしてます。<br>
            PHPのフレームワークにはLaravelを使っています。<br>
            <a href="https://github.com/hucklefriend/hgs3">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubリポジトリはこちら</a>
        </p>
    </section>

    <section class="my-5">
        <h2>バグの発見や要望など</h2>
        <p class="ml-3">
            バグの報告やご要望などありましたら、<a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}Twitter</a>か<a href="mailto:webmaster@horrorgame.net">メール</a>でご連絡をお願い致します。<br>
            {{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}GitHubのIssuesにIssueを登録して頂いても大丈夫です。
        </p>
    </section>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイトマップ</li>
        </ol>
    </nav>
@endsection