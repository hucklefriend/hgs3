@extends('haribote.layout')

@section('content')
    <div id="back" class="flex items-stretch">
        <div class="node">
            <div class="node-ball-cntr"><span class="node-ball"></span></div>
            <div class="back-line-cntr"><div class="back-line"></div></div>
        </div>
        <div>
            <a href="index">タイトル</a>
        </div>
    </div>
    <div class="flex items-stretch main-title">
        <div class="node">
            <div class="node-ball-cntr"><span class="node-ball"></span></div>
            <div class="title-line-cntr"><div class="title-line"></div></div>
        </div>
        <div>
            <h1 class="text-4xl">ホラーゲーム</h1>
        </div>
        <div>
            ＝
        </div>
    </div>
    <div id="contents">
        <div class="sub-network flex">
            <div class="line-cntr">
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
            </div>
            <div class="mt-4">
                <div class="flex">
                    <div>
                        <div class="flex items-center" style="overflow: visible;">
                            <h2 class="text-2xl sub-title"><span class="node-ball"></span>ゲームを探す</h2>
                            <div style="border:solid 1px white;width: calc(100% + 30px);height: 2px;"></div>
                        </div>

                        <div class="flex">
                            <div style="width: 20px;"></div>
                            <div class="text">
                                <p>
                                    ログイン状態維持のため、クッキーを使用しています。<br>
                                    クッキーはブラウザの設定で利用しないようにすることもできますが、
                                    利用しない場合は当サイトの一部機能がご利用いただけなくなります。<br>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="sub-network flex">
                            <div class="line-cntr">
                                <div class="line-vertical"></div>
                                <div class="line-horizontal"></div>
                            </div>
                            <div>
                                <h2 class="text-2xl sub-title"><span class="node-ball"></span>一覧</h2>
                            </div>
                        </div>
                        <div class="sub-network flex">
                            <div class="line-cntr">
                                <div class="line-vertical"></div>
                                <div class="line-horizontal"></div>
                            </div>
                            <div>
                                <h2 class="text-2xl sub-title"><span class="node-ball"></span>ハードから探す</h2>
                            </div>
                        </div>
                        <div class="sub-network flex">
                            <div class="line-cntr">
                                <div class="line-vertical"></div>
                                <div class="line-horizontal"></div>
                            </div>
                            <div>
                                <h2 class="text-2xl sub-title"><span class="node-ball"></span>プラットフォームから探す</h2>
                            </div>
                        </div>
                        <div class="sub-network flex">
                            <div class="line-cntr">
                                <div class="line-vertical"></div>
                                <div class="line-horizontal"></div>
                            </div>
                            <div>
                                <h2 class="text-2xl sub-title"><span class="node-ball"></span>メーカーから探す</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sub-network flex">
            <div class="line-cntr">
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl sub-title"><a href="#"><span class="node-ball"></span>新着情報</a></h2>

                <div>
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
                    連絡事項がある場合は、当サイト内のメッセージ機能でご連絡します。（まだ実装していませんが…）
                </p>
                </div>
            </div>
        </div>
        <div class="sub-network flex">
            <div class="line-cntr">
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl sub-title"><a href="#"><span class="node-ball"></span>ゲーム情報（外部サイト）</a></h2>


                <div>
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
                    ユーザー設定の画面で連携情報の削除を行うことができます。<br>
                    当サイト内のデータが削除されるだけで、外部サービス側には設定が残っていますので、外部サービス側での連携解除処理も行ってください。
                </p>
                </div>
            </div>
        </div>



        <div class="sub-network flex">
            <div class="line-cntr">
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl sub-title"><a href="#"><span class="node-ball"></span>Google Analytics</a></h2>


                <div>
                <p>
                    アクセス情報の収集・解析のために、<a href="https://www.google.com/intl/ja_jp/analytics" target="_blank">Google Analytics <i class="fas fa-sign-out-alt"></i></a>を利用しています。<br>
                    Google Analyticsはクッキーを使っての情報収集が行われております。<br>
                    データが収集、処理される仕組みについては、下記のサイトを参照ください。
                </p>

                <a href="https://policies.google.com/technologies/partner-sites?hl=ja" target="_blank">Google のサービスを使用するサイトやアプリから収集した情報の Google による使用 – ポリシーと規約 – Google <i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </div>



        <div class="sub-network flex">
            <div class="line-cntr">
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl sub-title"><a href="#"><span class="node-ball"></span>アフィリエイト</a></h2>

                <div>
                    <p>
                        下記のアフィリエイトに参加しています。<br>
                        当サイト内において、アフィリエイトの画像の表示や商品ページへのリンクを行っている部分があります。<br>
                        また、各サービスにおいて、クッキーを使ってのデータ収集が行われております。
                    </p>
                    <ul class="mb-4">
                        <li class="mb-2"><a href="https://affiliate.amazon.co.jp/" target="_blank">Amazon.co.jpアソシエイト <i class="fas fa-sign-out-alt"></i></a></li>
                        <li class="mb-2">
                            <a href="https://affiliate.dmm.com/" target="_blank">DMM アフィリエイト <i class="fas fa-sign-out-alt"></i></a>
                            <a href="https://affiliate.dmm.com/api/" target="_blank" class="ml-1"><img src="https://pics.dmm.com/af/web_service/com_135_17.gif" width="135" height="17" alt="WEB SERVICE BY DMM.com"></a>
                            <a href="https://affiliate.dmm.com/api/" target="_blank" class="ml-1"><img src="https://pics.dmm.com/af/web_service/r18_135_17.gif" width="135" height="17" alt="WEB SERVICE BY DMM.R18"></a>
                        </li>
                        <li class="mb-2"><a href="https://www.apple.com/jp/itunes/affiliates/" target="_blank">iTunes アフィリエイトプログラム <i class="fas fa-sign-out-alt"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sub-network flex">
            <div class="line-cntr">
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl sub-title"><a href="#"><span class="node-ball"></span>免責事項</a></h2>
                <div>
                    <p>当サイトで掲載している画像の著作権等は権利所有者のものです。</p>
                    <p>当サイトから他のサイトに移動された場合、移動先サイトで提供されるサービス等について一切の責任を負いません。</p>
                </div>
            </div>
        </div>

    </div>
@endsection
