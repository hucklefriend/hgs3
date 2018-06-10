@extends('layouts.app')

@section('content')
    <div class="content__inner">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        @if ($newInfoNum > 0)
                            <div class="d-flex justify-content-between card-title-flex">
                                <h5 class="card-title">新着情報</h5>

                                <div class="card-title-link">
                                    <a href="{{ route('新着情報') }}" class="badge badge-pill show-all"><small>すべて見る</small> <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>
                            @if ($newInfoNum > 1)
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
                                                <small>{{ format_date($nf['time']) }}</small>
                                            </div>
                                            <p class="mb-0">
                                                {!! $nf['text'] !!}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <h5 class="card-title">新着情報</h5>
                            <p class="card-text">新着情報はありません。</p>
                        @endif
                    </div>
                </div>
                @if ($notices->count() > 0)
                <div class="card card-hgn">
                    <div class="card-body">
                        <div class="d-flex justify-content-between card-title-flex">
                            <h5 class="card-title">お知らせ</h5>

                            <div class="card-title-link">
                                <a href="{{ route('お知らせ') }}" class="badge badge-pill show-all"><small>すべて見る</small> <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                        @foreach ($notices as $notice)
                            <div class="d-flex justify-content-between">
                                <div class="text-left force-break">
                                    <small>{{ format_date($notice->open_at_ts) }}</small><br>
                                    <p class="mb-0 force-break">{{ $notice->title }}</p>
                                </div>
                                <div class="align-self-center">
                                    <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}" class="btn btn-outline-dark border-0 d-block">
                                        <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                @endif
            </div>

            @if (!\Illuminate\Support\Facades\Auth::check())
            <div class="col-12 col-md-6">
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

            <div class="col-12 @if (\Illuminate\Support\Facades\Auth::check()) col-md-6 @endif mb-5">
                <p class="mb-1 text-muted"><small>スポンサーリンク</small> <i class="fab fa-amazon"></i></p>
                <div class="swiper-container" id="new_game">
                    <div class="swiper-wrapper">
                        @foreach ($newGames as $newGame)
                            <div class="swiper-slide">
                                <div class="text-center">
                                    <a href="{{ $newGame->shop_url }}" target="_blank" class="text-center">
                                        <img data-normal="{{ $newGame->small_image_url }}">
                                        <p class="force-break new-game-title">{{ $newGame->name }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next swiper-button-next-hgn"></div>
                    <div class="swiper-button-prev swiper-button-prev-hgn"></div>
                </div>
            </div>
            <script>
                let swiperNewGame = null;
                let slidesPerView = 3;
                $(function(){
                    @if (!\Illuminate\Support\Facades\Auth::check())
                    let windowWidth = $(window).width();
                    if (windowWidth < 768) {
                        slidesPerView = 3;
                    } else if (windowWidth < 992) {
                        slidesPerView = 5;
                    } else if (windowWidth < 1120) {
                        slidesPerView = 6;
                    } else {
                        slidesPerView = 8;
                    }

                    initNewGameSwiper(slidesPerView);

                    $(window).on('resize', function (){
                        let windowWidth = $(window).width();
                        if (windowWidth < 768) {
                            if (slidesPerView == 3) {
                                return;
                            }
                            slidesPerView = 3;
                        } else if (windowWidth < 992) {
                            if (slidesPerView == 5) {
                                return;
                            }
                            slidesPerView = 5;
                        } else if (windowWidth < 1120) {
                            if (slidesPerView == 6) {
                                return;
                            }

                            slidesPerView = 6;
                        } else {
                            if (slidesPerView == 8) {
                                return;
                            }

                            slidesPerView = 8;
                        }

                        initNewGameSwiper(slidesPerView);
                    });

                    @endif

                    initNewGameSwiper(slidesPerView);
                });

                function initNewGameSwiper(num)
                {
                    if (swiperNewGame != null) {
                        swiperNewGame.destroy(true, true);
                    }

                    swiperNewGame = new Swiper('#new_game', {
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        slidesPerView: num,
                        spaceBetween: 20,
                        loop: true,
                    });
                }

            </script>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4 top-item text-center">
                        <div class="top-item-title">Games</div>
                        <p>
                            どんなホラーゲームがあるかお探しですか？<br>
                            当サイトでは{{ $softNum }}個のホラーゲームを扱っています。<br>
                            ゲームの一覧がありますので、ぜひ眺めていってください。
                        </p>
                        <div class="tags__body">
                            <a href="{{ route('ゲーム一覧') }}">&gt;&gt; ゲーム一覧へ &lt;&lt;</a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item text-center">
                        <div class="top-item-title">Reviews</div>
                        <p>
                            ホラーゲームの評判をお探しですか？<br>
                            @if ($reviewNum == 0)
                                レビューを書いている人がいない状況です…<br>
                                レビューを書いてみたいという方はぜひ書いていってください。
                            @else
                                {{ $reviewNum }}件のユーザーのレビューがありますので、ぜひ見てください。<br>
                                レビューの投稿もお待ちしております。
                            @endif
                        </p>
                        <div class="tags__body">
                            <a href="{{ route('レビュートップ') }}">&gt;&gt; レビューへ &lt;&lt;</a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item text-center">
                        <div class="top-item-title">Friends</div>
                        <p>
                            同じホラーゲームが好きな人をお探しですか？<br>
                            {{ $userNum }}人のユーザーが参加しています。<br>
                            好きなゲームが近い人を探す機能は、近々実装を開始します。
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item text-center">
                        <div class="top-item-title">Sites</div>
                        <p>
                            ホラーゲームを扱っているサイトをお探しですか？<br>
                            {{ $siteNum }}個のサイトが登録されています。<br>
                            サイトをお持ちの方は、ぜひ登録していってください。
                        </p>
                        <div class="tags__body">
                            <a href="{{ route('サイトトップ') }}">&gt;&gt; サイトへ &lt;&lt;</a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item d-none">
                        <div class="top-item-title">Secondary Creations</div>
                        <p>
                            ホラーゲームの二次創作物をお探しですか？<br>
                            イラストや小説などを紹介できる機能はいずれ実装したいと考えております。
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 top-item d-none">
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
                    <div class="mr-2 mb-4 align-self-center"><a href="http://icooon-mono.com/" class="d-block p-2" target="_blank">ICOON MONO</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection
