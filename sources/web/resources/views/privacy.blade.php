@extends('layouts.app')

@section('title')プライバシーポリシー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>プライバシーポリシー</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">クッキーの利用</h4>
                <p>
                    ログイン状態維持のため、クッキーを使用しています。<br>
                    クッキーはブラウザの設定で利用しないようにすることもできますが、利用しない場合は当サイトの一部機能がご利用いただけなくなります。<br>
                    <br>
                    また、当サイトで利用している外部サービスにおいても、クッキーを利用して情報を収集しているものがあります。<br>
                    外部サービス毎に項目を用意しておりますので、本画面下部を参照ください。<br>
                    <br>
                    クッキーについて詳しくは、こちらを参照ください。
                </p>
                <a href="https://ja.wikipedia.org/wiki/HTTP_cookie" target="_blank">HTTP cookie - Wikipedia <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">メールアドレスの取得</h4>
                <p>
                    メール・パスワード認証を利用される場合に限り、メールアドレスを取得しています。<br>
                    メールアドレスは以下の用途に利用しています。
                </p>
                <ul>
                    <li>メール・パスワード認証の登録の際にメールをお送りしています。</li>
                    <li>メール・パスワード認証でログインする場合、メールアドレスの入力が必要です。</li>
                    <li>パスワードを忘れた場合に、再発行のためメールアドレスの入力が必要です。</li>
                    <li>パスワードを忘れた場合に、再発行のメールをお送りしています。</li>
                </ul>
                <p>
                    上記以外のことでメールアドレスの入力を求めたり、メールをお送りすることはありません。<br>
                    連絡事項がある場合は、当サイト内のメッセージ機能でご連絡します。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">外部サービスのアカウント情報</h4>
                <p>
                    当サイトでは、外部サービスを使ってログインや新規登録を行えます。<br>
                    外部サービスを利用される場合、アカウント情報を取得しています。<br>
                    利用できるサービスは以下の通りです。
                </p>
                <ul>
                    <li><a href="https://twitter.com/" target="_blank">Twitter <i class="fas fa-sign-out-alt"></i></a></li>
                    <li><a href="https://www.facebook.com/" target="_blank">Facebook <i class="fas fa-sign-out-alt"></i></a></li>
                    <li><a href="https://github.com/" target="_blank">GitHub <i class="fas fa-sign-out-alt"></i></a></li>
                    <li><a href="https://plus.google.com/" target="_blank">Google+ <i class="fas fa-sign-out-alt"></i></a></li>
                </ul>

                <p>
                    取得している情報は以下の通りです。
                </p>
                <ul>
                    <li>外部サイト内でのユーザーID</li>
                    <li>名前(ニックネームにあたるもの)</li>
                    <li>OAuth認証に必要なトークンおよびシークレットトークン</li>
                </ul>

                <p>
                    現在のところ、いずれのサービスにおいても新規登録とログインでのみアカウント情報の取得・利用を行っております。<br>
                    今後、増える可能性がありますが、その場合はこちらに記載していきます。
                </p>
                <p>
                    トークンおよびシークレットトークンは当サイト用に発行されたものです。<br>
                    これを保存しているからといって、 Twitterへの投稿が行える別のサービスになりすまして投稿を行うといったことはできません。
                </p>
                <p>
                    各サービスの連携設定で、当サイトとの連携を削除できますので、使いたくなくなった場合は外部サービス側での削除をお願いします。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">アフィリエイト</h4>

                <p>
                    下記のアフィリエイトに参加しています。<br>
                    当サイト内において、アフィリエイトの画像の表示や商品ページへのリンクを行っている部分があります。<br>
                    また、各サービスにおいて、クッキーを使ってのデータ収集が行われております。
                </p>
                <ul class="mb-4">
                    <li class="mb-2"><a href="https://affiliate.amazon.co.jp/" target="_blank">Amazon.co.jpアソシエイト <i class="fas fa-sign-out-alt"></i></a></li>
                    <li class="mb-2">
                        <a href="https://affiliate.dmm.com/" target="_blank">DMM アフィリエイト <i class="fas fa-sign-out-alt"></i></a>
                        <a href="https://affiliate.dmm.com/api/" target="_blank" class="ml-1"><img src="https://pics.dmm.com/af/web_service/com_135_17.gif" width="135" height="17" alt="WEB SERVICE BY DMM.com" /></a>
                        <a href="https://affiliate.dmm.com/api/" target="_blank" class="ml-1"><img src="https://pics.dmm.com/af/web_service/r18_135_17.gif" width="135" height="17" alt="WEB SERVICE BY DMM.R18" /></a>
                    </li>
                </ul>
                <p>
                    当サイトでは18禁のアダルトゲームも取り扱っていますが、下記の条件にあてはまらない限り、アダルトゲームのパッケージ画像の表示や商品ページへのリンク等、性的な表現が表示されないように制限しています。
                </p>
                <ul>
                    <li>当サイトのユーザーとして登録している</li>
                    <li>ユーザーの設定で、「18歳以上で、かつ暴力または性的な表現があっても問題ありません」を有効にしている</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Google Analytics</h4>

                <p>
                    アクセス情報の収集・解析のために、<a href="https://www.google.com/intl/ja_jp/analytics" target="_blank">Google Analytics <i class="fas fa-sign-out-alt"></i></a>を利用しています。<br>
                    Google Analyticsはクッキーを使っての情報収集が行われております。<br>
                    データが収集、処理される仕組みについては、下記のサイトを参照ください。
                </p>

                <a href="https://policies.google.com/technologies/partner-sites?hl=ja" target="_blank">Google のサービスを使用するサイトやアプリから収集した情報の Google による使用 – ポリシーと規約 – Google <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">免責事項</h4>

                <p>当サイトで掲載している画像の著作権等は権利所有者のものです。</p>
                <p>当サイトから他のサイトに移動された場合、移動先サイトで提供されるサービス等について一切の責任を負いません。</p>
            </div>
        </div>
    </div>
@endsection
