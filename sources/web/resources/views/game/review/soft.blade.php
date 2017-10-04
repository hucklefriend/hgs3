@extends('layouts.app')

@section('content')
    <h4></h4>

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/soft') }}/{{ $game->id }}">詳細へ</a>|
        <a href="{{ url('game/review/input') }}/{{ $game->id }}">投稿する</a>
    </nav>

    <div>

    </div>



    @if ($total !== null)
    <div style="display:table-row">
        <div style="display:table-cell">
            <span style="font-size: 250%">{{ $total->point }}</span>
        </div>

        <div style="display:table-cell">
            <span style="font-size: 200%">{{ $game->name }}</span>
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