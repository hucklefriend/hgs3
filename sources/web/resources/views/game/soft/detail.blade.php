@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム一覧') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <div class="text-center">
        <h1>{{ $soft->name }}</h1>
    </div>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ route('ゲームソフト編集', ['soft' => $soft->id]) }}" class="btn btn-sm btn-outline-info">データ修正</a>
    </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">パッケージ情報</h5>
                        <div class="text-right">
                            <a href="{{ route('パッケージ登録', ['soft' => $soft->id]) }}" class="btn btn-outline-dark btn-sm">追加</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
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
                        <div class="row">
                            <div class="col-4">
                                @include('game.common.packageImage', ['imageUrl' => $pkg->medium_image_url])
                            </div>
                            <div class="col-8">
                                <div><h5>{{ $pkg->name }}</h5></div>
                                <div>
                                    <i class="far fa-building"></i>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a>
                                    <i class="fas fa-gamepad"></i>&nbsp;{{ $pkg->platform_name }}
                                </div>
                                <div>{{ $pkg->release_at }}</div>
                                <div>
                                    @foreach ($pkg->shops as $shop)
                                    @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                                    @endforeach
                                </div>

                                @if (is_data_editor())
                                <hr>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-6">
                                        <a href="{{ route('パッケージ編集', ['soft' => $soft->id, 'package' => $pkg->id]) }}" class="btn btn-sm btn-outline-info">編集</a><br>
                                    </div>
                                    <div class="col-6 text-right">
                                        <form method="POST" action="{{ route('パッケージ削除処理', ['package' => $pkg->id]) }}" onsubmit="return confirm('削除します');">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if (isset($packages[$i + 1]))
                        @php $pkg = $packages[$i + 1]; @endphp
                        <br>
                        <div class="row">
                            <div class="col-4">
                                @include('game.common.packageImage', ['imageUrl' => $pkg->medium_image_url])
                            </div>
                            <div class="col-8">
                                <div><h5>{{ $pkg->name }}</h5></div>
                                <div>
                                    <i class="far fa-building"></i>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a>
                                    <i class="fas fa-gamepad"></i>&nbsp;{{ $pkg->platform_name }}
                                </div>
                                <div>{{ $pkg->release_at }}</div>
                                <div>
                                    @foreach ($pkg->shops as $shop)
                                        @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                                    @endforeach
                                </div>

                                @if (is_data_editor())
                                    <hr>
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-6">
                                            <a href="{{ route('パッケージ編集', ['soft' => $soft->id, 'package' => $pkg->id]) }}" class="btn btn-sm btn-outline-info">編集</a><br>
                                        </div>
                                        <div class="col-6 text-right">
                                            <form method="POST" action="{{ route('パッケージ削除処理', ['package' => $pkg->id]) }}" onsubmit="return confirm('削除します');">
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        </div>
                    @endfor
                    </div>
                        @if ($packageNum > 2)
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-default btn-sm" id="package_slider_prev">&lt;</button>
                        </div>
                        <div class="col-8 text-center" id="package_pager">
                        </div>
                        <div class="col-2 text-right">
                            <button class="btn btn-default btn-sm" id="package_slider_next">&gt;</button>
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
                    <h5 class="card-title">サイト <small>全{{ $siteNum }}件</small></h5>

                    <div class="card-text">
                        @if (empty($site))
                            <p>{{ $soft->name }}を扱っているサイトは登録されていません。</p>
                        @else
                            @foreach ($site as $s)
                                @include('site.common.minimal', ['s' => $s, 'u' => $siteUsers[$s->user_id]])
                                <hr>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('ソフト別サイト一覧', ['soft' => $soft->id]) }}">サイトを全て見る</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">お気に入り</h5>

                    <p class="card-text">
                        @if ($favoriteNum == 0)
                            お気に入りに登録しているユーザーはいません。
                        @else
                            <a href="{{ route('お気に入りゲーム登録ユーザー一覧', ['soft' => $soft->id]) }}">{{ $favoriteNum }}人のユーザー</a>がお気に入りに登録しています。
                        @endif
                    </p>

                    @auth
                    <hr>

                    @if ($isFavorite)
                        <p>あなたもその1人です。</p>
                        <form action="{{ route('お気に入りゲーム削除処理') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                            {{ method_field('DELETE') }}
                            <button class="btn btn-sm btn-warning">取り消す</button>
                        </form>
                    @else
                        <p>お気に入りゲームに登録しますか？</p>
                        <form action="{{ route('お気に入りゲーム登録処理') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                            <div class="text-center">
                                <button class="btn btn-info btn-sm">登録する</button>
                            </div>
                        </form>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @if ($series)
    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">同一シリーズの別タイトル</h5>
            <div class="d-flex flex-wrap">
                @foreach ($seriesSofts as $seriesSoft)
                    @include('game.common.packageCard', ['soft' => $seriesSoft])
                @endforeach
            </div>
        </div>
    </div>
    @endif
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