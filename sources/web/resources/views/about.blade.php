@extends('layouts.app')

@section('title')当サイトについて | @endsection

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>H.G.N.について</h1>

    <section class="my-4">
        <h2>H.G.N.とは</h2>
        <p class="ml-3">
            ホラーゲーム好きが集まるSNSサイトです。<br>
            外部のサイトの機能を活用する方針なので、外部サイトでできることは外部サイトにお任せしようと思います。<br>
            例えば、当サイトにはユーザー同士のメッセージ交換機能はありません。<br>
            同じホラーゲームが好きなユーザーを見かけたので交流したいなという場合は、Twitterやfacebookなどで行って頂ければと思います。
        </p>
    </section>

    <section class="my-5">
        <h2>ホラーゲームの基準</h2>
        <p class="ml-3">
            公式サイトやSteam、Amazon、Wikipediaなどでホラーゲームとして紹介されているゲームをホラーゲームとしています。<br>
            怖さは基準になっていません。<br>
            オカルトや伝奇のみではホラーゲームとして扱っていません。
        </p>
    </section>



    <section class="my-5">
        <h2>オープンソース</h2>
        <p class="ml-3">
            H.G.N.のソースコードをGitHubで公開しています。<br>
            PHPのLaravelを利用して開発しています。<br>
            <a href="https://github.com/hucklefriend/hgs3">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubリポジトリはこちら</a>
        </p>
    </section>

    <section class="my-5">
        <h2>バグの発見や要望など</h2>
        <p class="ml-3">
            バグの報告やご要望などありましたら、<a href="https://twitter.com/huckle_friend" target="_blank">Twitter</a>か<a href="mailto:webmaster@horrorgame.net">メール</a>でご連絡をお願い致します。<br>
            GitHubのIssuesにIssueを登録して頂いても大丈夫です。
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