@extends('layouts.app')

@section('content')
    <section>
        <div class="d-flex align-items-stretch">
            <div class="p-2 text-center">
                @include('game.common.package_image', ['imageUrl' => $pkg->small_image_url])
            </div>
            <div class="p-12">
                <h4>{{ $pkg->name }}</h4>
                <a href="{{ url2('game/soft') }}/{{ $game->id }}">ゲームの詳細情報</a> |
                <a href="{{ url('game/review/soft') }}/{{ $game->id }}">他のレビュー</a>
            </div>
        </div>
    </section>

    <section>

        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center">
                <span style="font-size: 300%;">{{ $review->point }}</span>
            </div>
            <div class="p-12 align-self-center">
                <div class="break_word" style="width: 100%;"><h5>{{ $review->title }}</h5></div>
                <div>
                    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $user->id }}">{{ $user->name }}</a>
                    {{ $review->post_date }}
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            <div class="p-6 align-self-center">
                <div style="min-width: 320px;max-width: 500px;width: 100%;">
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
            <div class="p-6">
                <div class="hidden-sm-down">
                    <table class="table table-sm no_border">
                        <tr>
                            <td>怖さ</td>
                            <td>@for ($i = 0; $i < $review->fear; $i++) ★@endfor</td>
                        </tr>
                        <tr>
                            <td>シナリオ</td>
                            <td>@for ($i = 0; $i < $review->story; $i++) ★@endfor</td>
                        </tr>
                        <tr>
                            <td>ボリューム</td>
                            <td>@for ($i = 0; $i < $review->volume; $i++) ★@endfor</td>
                        </tr>
                        <tr>
                            <td>グラフィック</td>
                            <td>@for ($i = 0; $i < $review->graphic; $i++) ★@endfor</td>
                        </tr>
                        <tr>
                            <td>サウンド</td>
                            <td>@for ($i = 0; $i < $review->sound; $i++) ★@endfor</td>
                        </tr>
                        <tr>
                            <td>操作性</td>
                            <td>@for ($i = 0; $i < $review->controllability; $i++) ★@endfor</td>
                        </tr>
                        <tr>
                            <td>難易度</td>
                            <td>@for ($i = 0; $i < $review->difficulty; $i++) ★@endfor</td>
                        </tr>
                        <tr>
                            <td>やりこみ</td>
                            <td>@for ($i = 0; $i < $review->crowded; $i++)★@endfor</td>
                        </tr>
                        <tr>
                            <td>おすすめ</td>
                            <td>@for ($i = 0; $i < $review->recommend; $i++)★@endfor</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>


        <div style="margin-top: 10px;">
            <h5>感想</h5>
            <p class="break_word">{{ $review->thoughts }}</p>
            <h5>おすすめ</h5>
            <p class="break_word">{{ $review->recommendatory }}</p>
        </div>



        <div>
            @if (!$isWriter && Auth::check())
                @if ($hasGood)
                    <form action="{{ url('game/review/good') }}/{{ $review->id }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ $csrfToken }}">
                        {{ $review->post_date }}
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }}&nbsp;<button class="btn btn-sm btn-warning">いいね取り消し</button>
                    </form>
                @else
                    <form action="{{ url('game/review/good') }}/{{ $review->id }}" method="POST">
                        <input type="hidden" name="_token" value="{{ $csrfToken }}">
                        {{ $review->post_date }}
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }} &nbsp;<button class="btn btn-sm btn-info">いいね</button>
                    </form>
                @endif
            @else
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }}
            @endif
            @if ($isWriter)
                <a href="{{ url2('game/review/good_history') }}/{{ $review->id }}">いいねしてくれたユーザー一覧</a>
            @endif
        </div>
    </section>
    @auth
    <hr>

    <section>
        @if (!$isWriter)
        <a href="{{ url('game/injustice_review/input') }}/{{ $review->id }}">このレビューを不正報告</a> |
        @endif
        <a href="{{ url('game/injustice_review/') }}/{{ $review->id }}">このレビューへの不正報告一覧</a>
    </section>
    @endauth
@endsection