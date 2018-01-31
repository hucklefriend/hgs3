
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
                                {{ $r->fear }},
                                {{ $r->story }},
                                {{ $r->volume }},
                                {{ $r->graphic }},
                                {{ $r->sound }},
                                {{ $r->controllability }},
                                {{ $r->difficulty }},
                                {{ $r->crowded }},
                                {{ $r->recommend }}
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
                                    stepSize: 1,
                                    min: 0,
                                    max: 5
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
            <table class="table table-sm no-border">
                <tr>
                    <td>怖さ</td>
                    <td>@for ($i = 0; $i < $r->fear; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>シナリオ</td>
                    <td>@for ($i = 0; $i < $r->story; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>ボリューム</td>
                    <td>@for ($i = 0; $i < $r->volume; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>グラフィック</td>
                    <td>@for ($i = 0; $i < $r->graphic; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>サウンド</td>
                    <td>@for ($i = 0; $i < $r->sound; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>操作性</td>
                    <td>@for ($i = 0; $i < $r->controllability; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>難易度</td>
                    <td>@for ($i = 0; $i < $r->difficulty; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>やりこみ</td>
                    <td>@for ($i = 0; $i < $r->crowded; $i++) ★@endfor</td>
                </tr>
                <tr>
                    <td>おすすめ</td>
                    <td>@for ($i = 0; $i < $r->recommend; $i++) ★@endfor</td>
                </tr>
            </table>
        </div>
    </div>
</div>