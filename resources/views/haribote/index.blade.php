@extends('haribote.layout')

@section('content')
    <div id="main-contents">


        <div class="flex items-stretch main-title">
            <div class="node">
                <span class="node-ball"></span>
                <div class="hgn-mt-line-cntr">
                    <div class="node-line"></div>
                </div>
            </div>
            <div class="flex items-stretch">
                <h1 class="text-4xl">ホラーゲームネットワーク</h1>
                <div class="sub-menu"></div>
            </div>
        </div>
        <div id="contents">


            <div class="sub-network flex">
                <div style=" width: 50px;position: relative;">
                    <div style="width: 14px;height:100%;border-right: solid 2px rgb(0, 200, 0);">

                    </div>
                    <div style="position: absolute;left: 12px;top:0;width: 40px;height: 40px;border-left: solid 2px rgb(0, 200, 0);border-bottom: solid 2px rgb(0, 200, 0);border-bottom-left-radius: 8px;"></div>
                </div>
                <div class="flex mt-4">
                    <div style="min-width: 300px;">
                        <span class="hgn-sub-network-title">はじめる</span>
                    </div>
                    <div>
                        <div style="margin-bottom: 2rem;">
                        <h2 class="text-2xl sub-title"><a href="game"><span class="node-ball"></span>アクセス</a></h2>
                        </div>
                        <div style="margin-bottom: 2rem;">
                        <h2 class="text-2xl sub-title"><a href="#"><span class="node-ball"></span>ログイン</a></h2>
                        </div>

                        <div style="margin-bottom: 2rem;">
                        <h2 class="text-2xl sub-title"><a href="#"><span class="node-ball"></span>ユーザー登録</a></h2>
                        </div>
                    </div>
                </div>
            </div>


            <div class="sub-network flex">
                <div style=" width: 50px;position: relative;">
                    <div style="position: absolute;left: 12px;top:0;width: 40px;height: 40px;border-left: solid 2px rgb(0, 200, 0);border-bottom: solid 2px rgb(0, 200, 0);border-bottom-left-radius: 8px;"></div>
                </div>
                <div class="flex mt-4">
                    <div style="min-width: 300px;" class="flex">
                        <div>
                            <span class="hgn-sub-network-title">当サイトについて</span>
                        </div>
                        <div style="display: inline-block;border-bottom: solid 2px rgb(0, 200, 0);width: 100%;height: 17px;">
                        </div>
                    </div>
                    <div>
                        <div style="margin-bottom: 2rem;">
                            <span class="hgn-sub-network-title">ホラーゲームネットワークとは？</span>
                        </div>
                        <div style="margin-bottom: 2rem;">
                            <span class="hgn-sub-network-title">利用規約</span>
                        </div>
                        <div style="margin-bottom: 2rem;">
                            <span class="hgn-sub-network-title"><a href="privacy_policy">プライバシーポリシー</a></span>
                        </div>
                        <div style="margin-bottom: 2rem;">
                            <span class="hgn-sub-network-title">お問い合わせ</span>
                        </div>
                        <div>
                            <span class="hgn-sub-network-title">サイトマップ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <canvas id="network-canvas"></canvas>
    </div>
@endsection
