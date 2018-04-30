@extends('layouts.app')

@section('content')
    <div class="content__inner">
        <div class="card card-hgn">
            <div class="card-body">
                <p class="card-text" style="color: #e7c3c3;">
                    現在、テスト用のユーザーとサイトが多数登録されています。<br>
                    本運営開始時に削除しますが、それまでは動作確認などで利用します。<br>
                    邪魔かと思いますが、ご理解とご了承をお願いしますm(_ _)m
                </p>
            </div>
        </div>

        <div class="row">
            <div class="@if(!Auth::check()) col-md-7 @else col-md-12 @endif">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h4 class="card-title">ようこそ</h4>
                        <p class="card-text">
                            {{ env('APP_NAME') }}は、ホラーゲーム好きが繋がるポータルサイトになるべく開発中のサイトです。<br>
                            <a href="http://horrorgame.net/">H.G.S.-Horror Game Search-</a>の後継として開発を進めています。<br>
                            公開テスト段階ですのでいろいろと不具合などありますが、よろしければテストにご協力ください。<br>
                            <a href="{{ route('当サイトについて') }}">当サイトについて詳しくはこちらをご覧ください。</a><br>
                        </p>
                        @if (!Auth::check())
                        <div class="text-center">
                            <a href="{{ route('ユーザー登録') }}" class="btn btn-primary btn-lg" role="button" aria-pressed="true">新規登録</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if (!Auth::check())
            <div class="col-md-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">ログイン</h5>
                        <div class="top-login d-flex">
                            <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</button>
                            </form>
                            <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }}</button>
                            </form>
                            <form method="POST" action="{{ route('GitHub', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</button>
                            </form>
                            <form method="POST" action="{{ route('Google', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GOOGLE_PLUS) }}</button>
                            </form>
                        </div>
                        <hr>
                        @if ($errors->has('login_error'))
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->get('login_error') as $msg)
                                    {{ nl2br(e($msg)) }}
                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <form method="POST" action="{{ route('ログイン処理') }}">
                            {{ csrf_field() }}
                            <div class="input-group mb-2">
                                <span class="input-group-addon" id="addon-mail"><i class="far fa-envelope"></i></span>
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control{{ $errors->has('login_error') ? ' has-danger' : '' }}" name="email" value="{{ old('email') }}" required placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="addon-mail">
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon" id="addon-password"><i class="fas fa-key"></i></span>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control{{ $errors->has('login_error') ? ' has-danger' : '' }}" name="password" required placeholder="パスワード" aria-label="パスワード" aria-describedby="addon-password">
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>

                            <div class="mt-3 d-flex">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm">ログイン</button>
                                </div>
                                <div style="margin-left: auto;">
                                    <a href="{{ route('パスワード再設定') }}">パスワードを忘れた</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">新着情報</h5>
                        @foreach ($newInfo as $nf)
                            <p class="card-text">
                                <small>{{ format_date($nf->open_at_ts) }}</small><br>
                                @if ($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_GAME)
                                    <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>が追加されました。
                                @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_SITE)
                                    新着サイトです！<a href="{{ route('サイト詳細', ['site' => $nf->site_id]) }}">「{{ hv($siteHash, $nf->site_id) }}」</a>
                                @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_REVIEW)
                                    <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>の新しいレビューが投稿されました！
                                @endif
                            </p>
                        @endforeach
                        @if ($newInfo->count() > 0)
                            <div class="text-center">
                                <a href="{{ route('新着情報') }}" >すべて見る</a>
                            </div>
                        @else
                            <p class="card-text">新着情報はありません。</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">お知らせ</h5>
                        @foreach ($notices as $notice)
                            <div class="my-2">
                                <div class="d-flex justify-content-between">
                                    <div class="text-left force-break">
                                        <small>{{ format_date($notice->open_at_ts) }}</small><br>
                                        {{ $notice->title }}
                                    </div>
                                    <div class="align-self-center">
                                        <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}" class="btn btn-outline-dark border-0 d-block">
                                            <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($notices->count() > 0)
                            <div class="text-center">
                                <a href="{{ route('お知らせ') }}" >すべて見る</a>
                            </div>
                        @else
                            <p class="card-text">お知らせはありません。</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">バグと今後の実装予定</h5>
                        バグや実装予定の機能は<a href="https://github.com/hucklefriend/hgs3/issues/" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubのIssue</a>で管理しています。<br>
                        バグの報告やご要望などありましたら、<a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}Twitter</a>か<a href="mailto:{{ env('ADMIN_MAIL') }}">{{ sns_icon(\Hgs3\Constants\SocialSite::MAIL) }}メール</a>でご連絡をお願い致します。<br>
                        {{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}GitHubのことをわかっている方は、Issueの作成やコメントをしていただいてもOKです。
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5>SPECIAL THANKS</h5>
                        <div class="d-flex flex-wrap">
                            <div class="m-3">
                                <a href="http://www.gameha.com/s/r.cgi?mode=r_link&id=18424" target="_blank">
                                    <img data-normal="{{ url('img/special_thanks/gameha_sd.gif') }}" border="0" alt="【創作・同人検索エンジン】GAMEHA.COM - ガメハコム - ">
                                </a>
                            </div>
                            <div class="m-3">
                                <a href="http://gameofserch.com/" target="_blank"><img data-normal="{{ url('img/special_thanks/gameofserch.gif') }}"></a>
                            </div>
                            <div class="m-3">
                                <a href="http://hemisphere.gonna.jp/sirensearch/" target="_blank"><img data-normal="{{ url('img/special_thanks/sirensearch.png') }}"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection