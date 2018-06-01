@extends('layouts.app')

@section('content')
    <div class="content__inner">
        <div class="row">
            @if ($notices->count() > 0)
                <div class="col-12 col-md-6">
                    <div class="card card-hgn">
                        <div class="card-body">
                            <h5 class="card-title">お知らせ</h5>
                        </div>

                        <div class="listview listview--hover">
                            @foreach ($notices as $notice)
                                <a class="listview__item" href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}">
                                    <div class="listview__content">
                                        <div class="listview__heading">{{ $notice->title }}</div>
                                        <p>{{ mb_substr($notice->message, 0, 200) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="card-body">
                            <div class="text-right">
                                <a href="{{ route('お知らせ') }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (!\Illuminate\Support\Facades\Auth::check())
            <div class="col-12 col-sm-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <div class="d-flex justify-content-between card-title-flex">
                            <h5 class="card-title">ログイン</h5>
                            <div>
                                <a href="{{ route('ユーザー登録') }}" class="btn btn-sm btn-outline-success" role="button" aria-pressed="true">新規登録</a>
                            </div>
                        </div>

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

                        <p class="mt-3 mb-0 text-center">
                            <small><a href="{{ route('HGSユーザーへ') }}">H.G.S.に登録していた方はこちらをご覧ください</a></small>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div @if (!\Illuminate\Support\Facades\Auth::check() || $notices->count() > 0) class="col-12 col-md-6" @else class="col-12 col-sm-8 col-md-7 col-lg-6 col-xl-5" @endif>
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">新着情報</h5>
                        @if ($newInfo->count() > 0)
                            @if ($newInfo->count() > 1)
                                <script>
                                    let swiper = null;
                                    $(function(){
                                        swiper = new Swiper('#new_information', {
                                            pagination: {
                                                el: '#packages_pagination',
                                                type: 'fraction',
                                            },
                                            navigation: {
                                                nextEl: '#packages_next',
                                                prevEl: '#packages_prev',
                                            },
                                            loop: true,
                                            autoplay: {
                                                delay: 3000,
                                                disableOnInteraction: false,
                                            },
                                        });
                                    });
                                </script>
                            @endif

                            <div class="swiper-container" id="new_information">
                                <div class="swiper-wrapper">
                                    @foreach ($newInfo as $nf)
                                    <div class="swiper-slide">
                                        <div>
                                            <small>{{ format_date($nf->open_at_ts) }}</small>
                                        </div>
                                        <p class="mb-0">
                                        @if ($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_GAME)
                                            <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>が追加されました。
                                        @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_SITE)
                                            新着サイトです！<a href="{{ route('サイト詳細', ['site' => $nf->site_id]) }}">「{{ hv($siteHash, $nf->site_id) }}」</a>
                                        @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_REVIEW)
                                            <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>の新しいレビューが投稿されました！
                                        @endif
                                        </p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <a href="{{ route('新着情報') }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                            </div>
                        @else
                            <p class="card-text">新着情報はありません。</p>
                        @endif
                    </div>
                </div>
            </div>

            @if (\Illuminate\Support\Facades\Auth::check() && $notices->count() == 0)

            <div class="hidden-xs-down col-sm-4 col-md-5 col-lg-6 col-xl-7">
            </div>
            @endif
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4 top-item">
                        <div class="top-item-title">
                            <a href="{{ route('ゲーム一覧') }}">Games</a>
                        </div>
                        <p>
                            どんなホラーゲームがあるかお探しですか？<br>
                            ゲームの一覧がありますので、ぜひ眺めていってください。<br>
                            {{ $softNum }}個のホラーゲームを扱っています。<br>
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item">
                        <div class="top-item-title"><a href="{{ route('レビュートップ') }}">Reviews</a></div>
                        <p>
                            ホラーゲームの評判をお探しですか？<br>
                            @if ($reviewNum == 0)
                                レビューを投稿する機能はあるのですが、まだ書いている人がいない状況です…<br>
                                今まで遊んだゲームでレビューを書いてみたいという方はぜひ書いていってください。
                            @else
                                {{ $reviewNum }}件のユーザーのレビューがありますので、ぜひ見てください。<br>
                                レビューの投稿もお待ちしております。
                            @endif
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item">
                        <div class="top-item-title">Friends</div>
                        <p>
                            同じホラーゲームが好きな人とのつながりをお探しですか？<br>
                            {{ $userNum }}人のユーザーがいます。<br>
                            好きなゲームが近い人を探す機能は、近々実装を開始します。<br>
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item">
                        <div class="top-item-title"><a href="{{ route('サイトトップ') }}">Sites</a></div>
                        <p>
                            ホラーゲームを扱っているホームページをお探しですか？<br>
                            {{ $siteNum }}個のサイトが登録されています。<br>
                            サイトをお持ちの方は、ぜひ登録していってください。
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item">
                        <div class="top-item-title">Secondary Creations</div>
                        <p>
                            ホラーゲームの二次創作物をお探しですか？<br>
                            イラストや小説などを紹介できる機能はいずれ実装したいと考えております。
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item">
                        <div class="top-item-title">Game Creations</div>
                        <p>
                            ご自身でホラーゲームを作られていますか？<br>
                            当サイトのカテゴリとして登録できる機能はいずれ実装したいと考えております。
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">SPECIAL THANKS</h5>
                <div class="d-flex flex-wrap justify-content-center justify-content-sm-start">
                    <div class="mr-2 mb-4"><a href="http://www.gameha.com/s/r.cgi?mode=r_link&id=18424" target="_blank"><img data-normal="{{ url('img/special_thanks/gameha_sd.gif') }}" border="0" alt="【創作・同人検索エンジン】GAMEHA.COM - ガメハコム - "></a></div>
                    <div class="mr-2 mb-4"><a href="http://gameofserch.com/" target="_blank"><img data-normal="{{ url('img/special_thanks/gameofserch.gif') }}"></a></div>
                    <div class="mr-2 mb-4"><a href="http://hemisphere.gonna.jp/sirensearch/" target="_blank"><img data-normal="{{ url('img/special_thanks/sirensearch.png') }}"></a></div>
                </div>
            </div>
        </div>
    </div>

@endsection
