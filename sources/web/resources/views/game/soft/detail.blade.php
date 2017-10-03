@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('game/soft') }}">ゲーム一覧</a></li>
        <li class="breadcrumb-item active">{{ $game->name }}</li>
    </ol>

    <h4>{{ $game->name }}</h4>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            パッケージ情報
                        </div>
                        <div class="col-2">
                            <a href="{{ url('game/package/add') }}/{{ $game->id }}">追加</a>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <script type="text/javascript" src="{{ url2('js/slick.min.js') }}"></script>
                    <link rel="stylesheet" type="text/css" href="{{ url2('css/slick.css') }}">
                    <link rel="stylesheet" type="text/css" href="{{ url2('css/slick-theme.css') }}">
                    <style>
                        .slick-dots {
                            bottom: 0 !important;
                            width: auto !important;
                            position: inherit !important;
                        }
                    </style>
                    <script>
                        $(function (){
                            let slick = $('.package_slide');
                            slick.slick({
                                dots: true,
                                appendDots: $('#package_pager'),
                                prevArrow: $('.slick-prev')
                            });
                            $('#package_slider_prev').click(function () {
                                slick.slick('slickPrev');
                            });
                            $('#package_slider_next').click(function () {
                                slick.slick('slickNext');
                            });
                        });
                    </script>
                    <div class="package_slide">

                    @for ($i = 0; $i < $package_num; $i += 2)
                        <div>
                        @php $pkg = $packages[$i]; @endphp
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ $pkg->medium_image_url }}" class="img-responsive" style="max-width: 100%;">
                            </div>
                            <div class="col-8">
                                <div><h4>{{ $pkg->name }}</h4></div>
                                <div>{{ $pkg->platform_name }}</div>
                                <div>{{ $pkg->release_date }}</div>
                                <div>
                                    <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                                </div>

                                @if ($isAdmin)
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
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ $pkg->medium_image_url }}" class="img-responsive" style="max-width: 100%;">
                            </div>
                            <div class="col-8">
                                <div><h4>{{ $pkg->name }}</h4></div>
                                <div>{{ $pkg->platform_name }}</div>
                                <div>{{ $pkg->release_date }}</div>
                                <div>
                                    <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                                </div>

                                @if ($isAdmin)
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
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-default" id="package_slider_prev">&lt;</button>
                        </div>
                        <div class="col-8 text-center" id="package_pager">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-default" id="package_slider_next">&gt;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header">
                    <a name="review">レビュー</a>
                    {{ $review->review_num }}件
                </div>
                <div class="card-block">
                    @if ($review != null)
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-3 text-center">
                                <small class="text-muted">ポイント</small>
                                <p style="font-size: 250%;">{{ $review->point }}</p>
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

                    <div>
                        平均プレイ時間 {{ $review->play_time }}時間
                    </div>
                    <div>
                        レビュー数 &nbsp;⇒<a href="{{ url('game/review/soft') }}/{{ $game->id }}">みんなのレビューを見る</a>
                    </div>
                    @else
                        <p>レビューは投稿されていません。<br>
                            最初のレビューを投稿してみませんか？</p>
                    @endif
                    <div style="margin-top: 25px;font-size: 150%;" class="text-center">
                        <a href="{{ url('game/review/input') }}/{{ $game->id }}">レビューを書く</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header">
                    ベースデータ
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-5">メーカー</div>
                        <div class="col-7"><a href="{{ url('game/company') }}/{{ $company->id }}">{{ $company->name }}</a></div>
                    </div>
                    <div class="row">
                        <div class="col-5">レビュー数</div>
                        <div class="col-7">{{ $base['review_num'] }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">お気に入り登録者数</div>
                        <div class="col-7">{{ $base['favorite_num'] }}</div>
                    </div>
                    @if ($isUser)
                    <div class="row">
                        <div class="col-5">お気に入り</div>
                        <div class="col-7">
                            @if ($isFavorite)
                                <form action="{{ url('user/favorite_game') }}" method="POST" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                    <input type="hidden" value="{{ $game->id }}" name="game_id">
                                    {{ method_field('DELETE') }}
                                    <span style="padding-right: 20px;">登録済み</span>
                                    <button class="btn btn-sm btn-warning">取り消す</button>
                                </form>
                            @else
                                <form action="{{ url('user/favorite_game') }}" method="POST" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                    <input type="hidden" value="{{ $game->id }}" name="game_id">
                                    <button class="btn btn-sm btn-info">登録する</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-5">サイト数</div>
                        <div class="col-7">{{ $base['site_num'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header">
                    サイト
                </div>
                <div class="card-block">
                    <div class="card-text">
                        @if (empty($site))
                            <p>このゲームを扱っているサイトは登録されていません。</p>
                        @else
                            @foreach ($site as $s)
                                <div>
                                    <h5>{{ $s->name }}</h5>
                                    <div><a href="{{ $s->url }}" target="_blank">{{ $s->url }}</a></div>
                                    <div>{{ mb_strimwidth($s->presentation, 0, 100, '...') }}</div>
                                    <div>→ <a href="{{ url('site/detail') }}/{{ $s->id }}">サイトの詳細情報</a></div>
                                </div>
                                <hr>
                            @endforeach
                            ⇒ <a href="{{ url('site/game/') }}/{{ $game->id }}">もっと見る</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header">
                    お気に入り登録者
                </div>
                <div class="card-block">
                    @if (!empty($favorite))
                        @foreach ($favorite as $fu)
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <a href="{{ url('user/profile') }}/{{ $fu->id }}">{{ $fu->name }}</a>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                            <p>
                                ⇒ <a href="{{ url('game/favorite/') }}/{{ $game->id }}">全ての登録者を見る</a>
                            </p>
                    @else
                        <p>
                            お気に入りに登録しているユーザーはいません。
                            @if ($isUser)
                            <br>お気に入りに登録しませんか？
                            <form action="{{ url('user/favorite_game') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                <input type="hidden" value="{{ $game->id }}" name="game_id">
                                <button class="btn btn-sm btn-info">登録する</button>
                            </form>
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header">
                    同一シリーズの別タイトル
                </div>
                <div class="card-block">
                    @if($series != null)
                        <ul class="list-group">
                            @foreach ($series['list'] as $sl)
                                <li class="list-group-item">
                                    <a href="{{ url('game/soft') }}/{{ $sl->id }}">{{ $sl->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>シリーズの別タイトルはありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header">
                    遊んだゲーム
                </div>
                <div class="card-block">
                    @if ($isUser)
                        @if ($playedGame == null)
                            <form method="POST" action="{{ url2('user/played_game') }}/{{ $game->id }}">
                                <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                <textarea name="comment" class="form-control"></textarea>
                                <button class="btn btn-default">登録</button>
                            </form>
                        @else
                            <form method="POST" action="{{ url2('user/played_game') }}/{{ $playedGame->id }}">
                                <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                {{ method_field('PUT') }}
                                <textarea name="comment" class="form-control">{{ $playedGame->comment }}</textarea>
                                <button class="btn btn-default">編集</button>
                            </form>
                            <hr>
                            <form method="POST" action="{{ url2('user/played_game') }}/{{ $playedGame->id }}">
                                <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger">削除</button>
                            </form>
                        @endif
                    @endif
                    <hr>
                    @foreach ($playedUsers as $pu)
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <a href="{{ url('user/profile') }}/{{ $pu->id }}">{{ $pu->name }}</a>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <p>
                        ⇒ <a href="{{ url('game/played_user/') }}/{{ $game->id }}">全ての登録者を見る</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-hgn">
                <div class="card-header"></div>
                <div class="card-block"></div>
            </div>
        </div>
    </div>

<style>
    section {
        margin-top: 30px;
    }
</style>




@endsection