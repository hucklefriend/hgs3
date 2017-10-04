@extends('layouts.app')

@section('content')
    <section>
        <div class="row">
            <div class="col-sm-2 text-center">
                <img src="{{ $pkg->small_image_url }}" class="thumbnail">
            </div>
            <div class="col-sm-10">
                <h4>{{ $pkg->name }}</h4>
                <a href="{{ url2('game/soft') }}/{{ $game->id }}">ゲームの詳細情報</a> |
                <a href="{{ url('game/review/soft') }}/{{ $game->id }}">他のレビュー</a>
            </div>
        </div>
    </section>

    <section>
        <div>
            @if (!$isWriter && Auth::check())
                @if ($hasGood)
                    <form action="{{ url('game/review/good') }}/{{ $review->id }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ $csrfToken }}">
                        {{ $review->post_date }}
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $user->id }}">{{ $user->name }}</a>
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }}&nbsp;<button class="btn btn-sm btn-warning">いいね取り消し</button>
                    </form>
                @else
                    <form action="{{ url('game/review/good') }}/{{ $review->id }}" method="POST">
                        <input type="hidden" name="_token" value="{{ $csrfToken }}">
                        {{ $review->post_date }}
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $user->id }}">{{ $user->name }}</a>
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }} &nbsp;<button class="btn btn-sm btn-info">いいね</button>
                    </form>
                @endif
            @else
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }}
                <a href="{{ url2('game/review/good_history') }}/{{ $review->id }}">いいねしてくれたユーザー一覧</a>
            @endif
        </div>


        <div class="row" style="margin-bottom: 15px;">
            <div class="col-sm-2 text-center">
                <div style="display: flex;justify-content: center;align-items: center;height: 100%;">
                    <div style="font-size: 300%;">{{ $review->point }}</div>
                </div>
            </div>
            <div class="col-sm-5">
                <div style="width: 320px;">
                    <canvas id="review_chart"></canvas>
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
                                        display: false
                                    },
                                    scale: {
                                        ticks: {
                                            beginAtZero: true,
                                            stepSize: 1
                                        }
                                    }
                                },
                                responsive: true
                            });
                        });
                    </script>
                </div>
            </div>
        </div>


        <div style="margin-top: 10px;" class="break_word">
            <h4>{{ $review->title }}</h4>
        </div>

        <div style="margin-top: 10px;">
            <h5>感想</h5>
            <p class="break_word">{{ $review->thoughts }}</p>
            <h5>おすすめ</h5>
            <p class="break_word">{{ $review->recommendatory }}</p>
        </div>

        <div>

        </div>
    </section>

    <section>
        @if (!$isWriter)
        <a href="{{ url('game/injustice_review/input') }}/{{ $review->id }}">このレビューを不正報告</a> |
        @endif
        <a href="{{ url('game/injustice_review/') }}/{{ $review->id }}">このレビューへの不正報告一覧</a>
    </section>
@endsection