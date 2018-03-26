@extends('layouts.app')

@section('title')レビュー投稿について | @endsection

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>レビュー投稿について</h1>

    <section class="my-4">
        <h2>評価ポイント</h2>
        <p class="ml-3">
            怖さ×5 + (良いところの数 + すごくいいところの数) - (悪いところの数 + すごく悪いところの数)<br>
            なお、今後「総評」について、感情分析にかけた結果のポイントを加味するようにしたいと考えております。
        </p>
    </section>

    <section class="my-5">
        <h2>レビューはゲームの内容を</h2>
        <p class="ml-3">
            ゲームの内容の良かった点や悪かった点を記入してください。<br>
            価格や、ハード、開発者の言動などはゲームの内容とは関係ないので評価の対象に加えないでください。<br>
            そのような内容が入ったレビューは削除対象となります。
        </p>
    </section>

    <section class="my-5">
        <h2>メーカーについて</h2>
        <p class="ml-3">
            各ゲームのメーカーは「パブリッシャー(販売元)」を表示しています。<br>
            開発元ではありません。<br>
            例：「零～月蝕の仮面～」は開発はテクモですが販売は任天堂なので、任天堂として扱っています。
        </p>
    </section>

    <section class="my-5">
        <h2>移植とリメイクについて</h2>
        <p class="ml-3">
            リメイクは別ゲームとして扱い、移植は同じゲームとして扱っています。<br>
            例：PS2の「零～紅い蝶～」とそのXBOXへの移植版「FATAL FRAME2 CRIMSON BUTTERFLY」は同じゲームですが、 WiiUのリメイク版「零～真紅の蝶～」は別ゲームです。
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