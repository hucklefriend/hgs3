@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>{{ $game->name }}</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            パッケージ情報
                        </div>
                        <div class="col-4 text-right">
                            @if ($isEditor)
                            <a href="{{ url('game/soft/package/add') }}/{{ $game->id }}">追加</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($package_num > 2)

                    <script type="text/javascript" src="{{ url2('js/slick.min.js') }}"></script>
                    <link rel="stylesheet" type="text/css" href="{{ url2('css/slick.css') }}">
                    <link rel="stylesheet" type="text/css" href="{{ url2('css/slick-theme.css') }}">
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
                    @for ($i = 0; $i < $package_num; $i += 2)
                        <div>
                        @php $pkg = $packages[$i]; @endphp
                        <div class="row">
                            <div class="col-4">
                                @include('game.common.package_image', ['imageUrl' => $pkg->medium_image_url])
                            </div>
                            <div class="col-8">
                                <div><h4>{{ $pkg->name }}</h4></div>
                                <div>
                                    <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;<a href="{{ url2('game/company') }}/{{ $pkg->company_id }}">{{ $pkg->company_name }}</a>
                                    <i class="fa fa-gamepad" aria-hidden="true"></i>&nbsp;{{ $pkg->platform_name }}
                                </div>
                                <div>{{ $pkg->release_date }}</div>
                                <div>
                                    <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                                </div>

                                @if ($isEditor)
                                <hr>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-6">
                                        <a href="{{ url('game/package/edit') }}/{{ $game->id }}/{{ $pkg->id }}">編集</a><br>
                                    </div>
                                    <div class="col-6 text-right">
                                        <form method="POST" action="{{ url('game/package/delete') }}/{{ $pkg->id }}" onsubmit="return confirm('削除します');">
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
                                @include('game.common.package_image', ['imageUrl' => $pkg->medium_image_url])
                            </div>
                            <div class="col-8">
                                <div><h4>{{ $pkg->name }}</h4></div>
                                <div>
                                    <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;<a href="{{ url2('game/company') }}/{{ $pkg->company_id }}">{{ $pkg->company_name }}</a>
                                    <i class="fa fa-gamepad" aria-hidden="true"></i>&nbsp;{{ $pkg->platform_name }}
                                </div>
                                <div>{{ $pkg->release_date }}</div>
                                <div>
                                    <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                                </div>

                                @if ($isEditor)
                                    <hr>
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-6">
                                            <a href="{{ url('game/package/edit') }}/{{ $game->id }}/{{ $pkg->id }}">編集</a><br>
                                        </div>
                                        <div class="col-6 text-right">
                                            <form method="POST" action="{{ url('game/package/delete') }}/{{ $pkg->id }}" onsubmit="return confirm('削除します');">
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
                        @if ($package_num > 2)
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-warning btn-sm" id="package_slider_prev">&lt;</button>
                        </div>
                        <div class="col-8 text-center" id="package_pager">
                        </div>
                        <div class="col-2 text-right">
                            <button class="btn btn-warning btn-sm" id="package_slider_next">&gt;</button>
                        </div>
                    </div>
                        @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">
                    <a name="review">レビュー</a>
                    {{ $review->review_num }}件
                </div>
                <div class="card-body">
                    @if ($review != null)
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-3 text-center">
                                <div class="review_point_outline">
                                    <p class="review_point">{{ $review->point }}</p>
                                </div>
                            </div>
                            <div class="col-9">
                                <canvas id="review_chart"></canvas>
                            </div>
                        </div>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
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
                                            {{ $review->fear }},
                                            {{ $review->story }},
                                            {{ $review->volume }},
                                            {{ $review->graphic }},
                                            {{ $review->sound }},
                                            {{ $review->controllability }},
                                            {{ $review->difficulty }},
                                            {{ $review->crowded }},
                                            {{ $review->recommend }}
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
                        <p>レビューは投稿されていません。<br>
                            最初のレビューを投稿してみませんか？</p>
                    @endif
                    <hr>
                        @if ($isUser)
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <a href="{{ url('game/review/soft') }}/{{ $game->id }}">レビューを見る</a>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <a href="{{ url('game/review/input') }}/{{ $game->id }}">レビューを書く</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center">
                                <a href="{{ url('game/review/soft') }}/{{ $game->id }}">レビューを見る</a>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">
                    サイト <small>{{ $base['site_num'] }}件</small>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        @if (empty($site))
                            <p>{{ $game->name }}を扱っているサイトは登録されていません。</p>
                        @else
                            @foreach ($site as $s)
                                @include('site.common.minimal', ['s' => $s, 'noUser' => true])
                                <hr>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ url('site/game/') }}/{{ $game->id }}">
                                    サイトを全て見る
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">
                    お気に入り登録ユーザー <small>{{ $base['favorite_num'] }}人</small>
                </div>
                <div class="card-body">
                    @if (!empty($favorite))
                        @foreach ($favorite as $fu)
                            <div class="row">
                                <div class="col-1">
                                    @include('user.common.icon', ['u' => $fu])
                                </div>
                                <div class="col-10">
                                    @include('user.common.user_name', ['id' => $fu->id, 'name' => $fu->name])
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        <div class="text-center">
                            <a href="{{ url('game/favorite/') }}/{{ $game->id }}">
                                お気に入り登録ユーザーを全て見る
                            </a>
                        </div>
                    @else
                        <p>お気に入りに登録しているユーザーはいません。</p>
                    @endif
                </div>
                @if ($isUser)
                <div class="card-footer">
                    @if ($isFavorite)
                        <form action="{{ url('user/favorite_game') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ $csrfToken }}">
                            <input type="hidden" value="{{ $game->id }}" name="game_id">
                            {{ method_field('DELETE') }}
                            <div class="text-center">
                                <span style="padding-right: 10px;">登録済み</span>
                                <button class="btn btn-sm btn-warning">取り消す</button>
                            </div>
                        </form>
                    @else
                        <form action="{{ url('user/favorite_game') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ $csrfToken }}">
                            <input type="hidden" value="{{ $game->id }}" name="game_id">
                            <div class="text-center">
                                <button class="btn btn-info">お気に入りに登録する</button>
                            </div>
                        </form>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">
                    同一シリーズの別タイトル
                </div>
                @if($series != null)
                    <ul class="list-group list-group-flush">
                        @foreach ($series['list'] as $sl)
                            <li class="list-group-item">
                                <a href="{{ url('game/soft') }}/{{ $sl->id }}">{{ $sl->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="card-body">
                        <div class="card-text">
                            <p>シリーズの別タイトルはありません。</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection