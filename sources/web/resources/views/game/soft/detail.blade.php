@extends('layouts.app')

@section('title')ゲーム@endsection
@section('global_back_link'){{ route('ゲーム一覧') }}@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-hgn">
                <div class="card-body">
                    <h1 class="card-title">{{ $soft->name }}</h1>
                    <div class="d-flex flex-column flex-sm-row">
                        @if ($hasOriginalPackageImage)
                            <div class="text-center mb-3">
                                @include('game.common.packageImage', ['imageUrl' => medium_image_url($originalPackage)])
                            </div>
                        @endif
                        <div class="ml-2">
                            @if (!empty($soft->introduction))
                            <div>
                                <blockquote class="blockquote soft-blockquote">
                                    <p class="mb-0">{!! nl2br(e($soft->introduction)) !!}</p>
                                    @if (!empty($soft->introduction_from))
                                    <div class="text-right mt-2">
                                        <footer class="blockquote-footer">{!! $soft->introduction_from !!}</footer>
                                    </div>
                                    @endif
                                </blockquote>
                            </div>
                            @endif
                            @if (!empty($platforms))
                            <div class="d-flex mb-2">
                                <div style="width: 30px;" class="text-center">
                                    <i class="fas fa-gamepad"></i>
                                </div>
                                <div class="d-flex flex-wrap">
                                @foreach ($platforms as $plt)
                                    <a href="#" class="mr-2 badge badge-light">{{ $pltHash[$plt] ?? '？' }}</a>
                                @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($officialSites->isNotEmpty())
                            <div class="d-flex">
                                <div style="width: 30px;" class="text-center">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="d-flex flex-wrap">
                                @foreach ($officialSites as $officialSite)
                                    <a href="{{ $officialSite->url }}" target="_blank" class="ml-2"><small>{{ $officialSite->title }}</small></a>
                                @endforeach
                                </div>
                            </div>
                            @endif

                            @if (Auth::check())
                            <div class="mt-4">
                                @if ($isFavorite)
                                    <form action="{{ route('お気に入りゲーム削除処理') }}" method="POST" onsubmit="return confirm('お気に入り解除していいですか？');">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-favorite2 btn--icon"><i class="fas fa-star"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('お気に入りゲーム登録処理') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                                        <button class="btn btn-favorite btn--icon"><i class="far fa-star"></i></button>
                                    </form>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">パッケージ情報</h4>

                    @if ($packageNum > 2)

                        <script type="text/javascript" src="{{ url('js/slick.min.js') }}"></script>
                        <link rel="stylesheet" type="text/css" href="{{ url('css/slick.css') }}">
                        <link rel="stylesheet" type="text/css" href="{{ url('css/slick-theme.css') }}">
                        <style>
                            .slick-dots {
                                bottom: 0 !important;
                                width: auto !important;
                                position: inherit !important;
                            }

                            .package_slide {
                                visibility: hidden;
                            }

                            .package_slide div {
                                outline: none;
                            }

                        </style>
                        <script>
                            $(function (){
                                let slick = $('.package_slide');
                                slick.slick({
                                    arrows: false,
                                    dots: true,
                                    appendDots: $('#package_pager'),
                                    prevArrow: $('.slick-prev')
                                });

                                $('.package_slide').css('visibility', 'visible');
                                $('#package_slider_prev').click(function () {
                                    slick.slick('slickPrev');
                                });
                                $('#package_slider_next').click(function () {
                                    slick.slick('slickNext');
                                });
                            });
                        </script>

                    @endif
                    <div class="package_slide">
                        @for ($i = 0; $i < $packageNum; $i += 2)
                            <div>
                                @php $pkg = $packages[$i]; @endphp
                                <div class="d-flex">
                                    <div class="package-image-small">
                                        @include('game.common.packageImage', ['imageUrl' => small_image_url($pkg)])
                                    </div>
                                    <div class="ml-3">
                                        <div class="package-title">{{ $pkg->name }}</div>
                                        <div class="d-flex flex-wrap package-info">
                                            <span class="mr-3"><i class="far fa-building"></i>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a></span>
                                            <span class="mr-3"><i class="fas fa-gamepad"></i>&nbsp;<a href="{{ route('プラットフォーム詳細', ['platform' => $pkg->platform_id]) }}">{{ $pkg->platform_name }}</a></span>
                                            <span><i class="far fa-calendar-alt"></i> {{ $pkg->release_at }}</span>
                                        </div>
                                        <div class="mt-2">
                                            @foreach ($pkg->shops as $shop)
                                                @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @if (isset($packages[$i + 1]))
                                    @php $pkg = $packages[$i + 1]; @endphp
                                    <br>
                                    <div class="d-flex">
                                        <div class="package-image-small">
                                            @include('game.common.packageImage', ['imageUrl' => small_image_url($pkg)])
                                        </div>
                                        <div class="ml-3">
                                            <div class="package-title">{{ $pkg->name }}</div>
                                            <div class="d-flex flex-wrap package-info">
                                                <span class="mr-3"><i class="far fa-building"></i>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a></span>
                                                <span class="mr-3"><i class="fas fa-gamepad"></i>&nbsp;<a href="{{ route('プラットフォーム詳細', ['platform' => $pkg->platform_id]) }}">{{ $pkg->platform_name }}</a></span>
                                                <span><i class="far fa-calendar-alt"></i> {{ $pkg->release_at }}</span>
                                            </div>
                                            <div class="mt-2">
                                                @foreach ($pkg->shops as $shop)
                                                    @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                    @if ($packageNum > 2)
                        <div class="row">
                            <div class="col-2">
                                <button class="btn btn-light btn-sm" id="package_slider_prev"><i class="fas fa-angle-left"></i></button>
                            </div>
                            <div class="col-8 text-center" id="package_pager">
                            </div>
                            <div class="col-2 text-right">
                                <button class="btn btn-light btn-sm" id="package_slider_next"><i class="fas fa-angle-right"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">レビュー</h5>
                    <p class="card-text">工事中</p>
                </div>
{{--
                <div class="card-body">
                    @if ($reviewTotal != null)
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-3 text-center">
                                <div class="review-point-outline">
                                    <p class="review-point">{{ $reviewTotal->point }}</p>
                                </div>
                            </div>
                            <div class="col-9">
                                <canvas id="review_chart"></canvas>
                            </div>
                        </div>

                        <script>
                            $(function (){
                                let ctx = $("#review_chart");

                                let data = {
                                    labels: ["怖さ", "シナリオ", "ボリューム", "グラフィック", "サウンド", "操作性", "難易度", "やりこみ", "オススメ"],
                                    datasets: [{
                                        fill: false,
                                        label: "",
                                        backgroundColor: "white",
                                        borderColor: "red",
                                        pointBackgroundColor: "red",
                                        data: [
                                            {{ $reviewTotal->fear }},
                                            {{ $reviewTotal->story }},
                                            {{ $reviewTotal->volume }},
                                            {{ $reviewTotal->graphic }},
                                            {{ $reviewTotal->sound }},
                                            {{ $reviewTotal->controllability }},
                                            {{ $reviewTotal->difficulty }},
                                            {{ $reviewTotal->crowded }},
                                            {{ $reviewTotal->recommend }}
                                        ]
                                    }]
                                };

                                let chart = new Chart(ctx, {
                                    type: 'radar',
                                    data: data,
                                    options: {
                                        legend: {
                                            display: false,
                                            position: 'top',
                                        },
                                        title: {
                                            display: false,
                                            text: 'Chart.js Radar Chart'
                                        },
                                        scale: {
                                            ticks: {
                                                beginAtZero: true,
                                                stepSize: 1
                                            }
                                        },
                                        responsive: true
                                    }
                                });
                            });
                        </script>
                    @else
                        <p>
                            レビューは投稿されていません。
                            @auth
                            <br>
                            最初のレビューを投稿してみませんか？
                            @endauth
                        </p>
                    @endif
                        @if (\Illuminate\Support\Facades\Auth::check())
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <a href="{{ route('ソフト別レビュー一覧', ['soft', $soft->id]) }}">レビューを見る</a>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <a href="{{ route('レビューパッケージ選択', ['soft', $soft->id]) }}">レビューを書く</a>
                                    </div>
                                </div>
                            </div>
                        @elseif ($reviewTotal !== null)
                            <hr>
                            <div class="text-center">
                                <a href="{{ route('ソフト別レビュー一覧', ['soft' => $soft->id]) }}">レビューを見る</a>
                            </div>
                        @endif
                </div>
--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">サイト <small>{{ number_format($siteNum) }}サイト</small></h4>

                    <div class="card-text">
                        @if (empty($site))
                            <p>サイトは登録されていません。</p>
                        @else
                            @foreach ($site as $s)
                                <div style="margin-bottom: 20px;">
                                @include('site.common.minimal', ['s' => $s])
                                </div>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('ソフト別サイト一覧', ['soft' => $soft->id]) }}">すべて見る</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">お気に入り <small>{{ number_format($favoriteNum) }}人</small></h4>
                    <div class="card-text">
                        @if ($favoriteNum == 0)
                            お気に入りに登録しているユーザーはいません。
                        @else
                            @foreach ($favorites as $favorite)
                                <div class="mb-3">
                                    @include('user.common.icon', ['u' => $users[$favorite->user_id]])
                                    @include('user.common.user_name', ['u' => $users[$favorite->user_id], 'followStatus' => $followStatus[$favorite->user_id] ?? \Hgs3\Constants\FollowStatus::NONE])
                                </div>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('お気に入りゲーム登録ユーザー一覧', ['soft' => $soft->id]) }}">すべて見る</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($series)
    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">同じシリーズのゲーム</h5>
            <div class="package-list">
                @foreach ($seriesSofts as $seriesSoft)
                    @include('game.common.packageCard', ['soft' => $seriesSoft, 'favorites' => $favoriteHash])
                @endforeach
            </div>
        </div>
    </div>
    @endif


    <div class="d-flex justify-content-between">
        <a href="{{ route('ゲーム詳細', ['soft' => $prevGame->id]) }}" class="btn btn-light">
            <i class="fas fa-angle-left"></i>
            前のゲーム
        </a>
        <a href="{{ route('ゲーム詳細', ['soft' => $nextGame->id]) }}" class="btn btn-light">
            次のゲーム
            <i class="fas fa-angle-right"></i>
        </a>
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection