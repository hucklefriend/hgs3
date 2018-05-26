@extends('layouts.app')

@section('title')プライバシーポリシー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

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
                    クッキーについて詳しくは、こちらを参照ください。<br>
                    <a href="https://ja.wikipedia.org/wiki/HTTP_cookie" target="_blank">HTTP cookie - Wikipedia</a>
                </p>
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
                    <li>パスワードを忘れた場合の再設定にメールをお送りしています。</li>
                </ul>
                <p>
                    上記以外のことでメールをお送りすることはありません。<br>
                    連絡事項がある場合は、当サイト内のメッセージ機能でご連絡します。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">外部サイトのアカウント情報</h4>

                <p>
                    主にログインのために、外部サイトのアカウント情報を取得しています。<br>
                    利用しているサービスは以下の通りです。
                </p>

                <ul>
                    <li><a href="https://twitter.com/" target="_blank">Twitter</a></li>
                    <li><a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
                    <li><a href="https://github.com/" target="_blank">GitHub</a></li>
                    <li><a href="https://plus.google.com/" target="_blank">Google+</a></li>
                </ul>
                <p>
                    現在のところ、いずれのサービスにおいても、新規登録とログインでのみアカウント情報の取得・利用を行っております。<br>
                    今後、増える可能性がありますが、その場合はこちらに記載していきます。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">アフィリエイトサービス</h4>

                <p>
                    下記のアフィリエイトサービスに参加しています。<br>
                    当サイト内において、アフィリエイトサービスの画像の表示や商品ページへのリンクを行っている部分があります。<br>
                    また、クッキーを使っての情報収集が行われております。
                </p>
                <ul>
                    <li class="mb-2"><a href="https://affiliate.amazon.co.jp/" target="_blank">Amazon.co.jpアソシエイト</a></li>
                    <li class="mb-2">
                        <a href="https://affiliate.dmm.com/" target="_blank">DMM アフィリエイト</a>
                        <a href="https://affiliate.dmm.com/api/" target="_blank"><img src="https://pics.dmm.com/af/web_service/com_135_17.gif" width="135" height="17" alt="WEB SERVICE BY DMM.com" /></a>
                        <a href="https://affiliate.dmm.com/api/" target="_blank"><img src="https://pics.dmm.com/af/web_service/r18_135_17.gif" width="135" height="17" alt="WEB SERVICE BY DMM.R18" /></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Google Analytics</h4>

                <p>
                    アクセス情報の収集・解析のために、<a href="https://www.google.com/intl/ja_jp/analytics" target="_blank">Google Analytics</a>を利用しています。<br>
                    Google Analyticsはクッキーを使っての情報収集が行われております。<br>
                    データが収集、処理される仕組みについては、下記のサイトを参照ください。<br>
                    <a href="https://policies.google.com/technologies/partner-sites?hl=ja" target="_blank">Google のサービスを使用するサイトやアプリから収集した情報の Google による使用 – ポリシーと規約 – Google</a>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">免責事項</h4>

                <p>当サイトで掲載している画像の著作権・肖像権等は各権利所有者に帰属致します。</p>
                <p>当サイトから他のサイトに移動された場合、移動先サイトで提供されるサービス等について一切の責任を負いません。</p>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">プライバシーポリシー</li>
        </ol>
    </nav>
@endsection