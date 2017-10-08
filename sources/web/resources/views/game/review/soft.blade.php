@extends('layouts.app')

@section('content')
    @if ($total !== null)

        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center" style="min-width: 3em;">
                <div class="review_point_outline">
                    <p class="review_point">{{ $total->point }}</p>
                </div>
            </div>
            <div class="p-10 align-self-center">
                <div class="break_word" style="width: 100%;"><h5>{{ $game->name }}</h5></div>
                <a href="{{ url('game/soft') }}/{{ $game->id }}">ゲームの詳細</a> |
                <a href="{{ url('game/review/input') }}/{{ $game->id }}">レビューを投稿する</a>
            </div>
        </div>

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
                            {{ $total->fear }},
                            {{ $total->story }},
                            {{ $total->volume }},
                            {{ $total->graphic }},
                            {{ $total->sound }},
                            {{ $total->controllability }},
                            {{ $total->difficulty }},
                            {{ $total->crowded }},
                            {{ $total->recommend }}
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

    <div>
        レビュー数 {{ $total->review_num }}
    </div>

    {{ $pager }}

        @foreach ($reviews as $r)
            @include('game.review.common.normal', ['r' => $r, 'showLastMonthGood' => false])
            @if (!$loop->last)
                <hr>
            @endif
        @endforeach

    {{ $pager }}
    @else

        <p>レビューが投稿されていません。</p>



    @endif

@endsection