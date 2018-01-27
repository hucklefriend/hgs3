@extends('layouts.app')

@section('content')
    <style>
        .review_value_text {
            margin-left: 10px;
        }

        .value_label {
            width: 120px;
        }
    </style>

    <div class="d-flex align-items-stretch">
        <div class="align-self-top p-2">
            @include ('game.common.package_image', ['imageUrl' => $package->small_image_url])
        </div>
        <div class="align-self-top">
            <div>
                <h4>{{ $package->name }}のレビューを書く</h4>
            </div>
            <div>
                <a href="{{ url2('review/package_select') }}/{{ $soft->id }}">パッケージを選び直す</a>
            </div>
        </div>
    </div>

    <hr>

    @if ($isDraft)
    <div class="alert alert-warning" role="alert">
        下書きを読み込みました。
    </div>
    @endif

    <form method="POST" action="{{ url2('review/confirm/' . $soft->id . '/' . $package->id) }}" autocomplete="off">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">一言(タイトル)</label>
            <input type="text" name="title" id="title" class="form-control{{ invalid($errors, 'title') }}" value="{{ $draft->title }}" maxlength="100" required>
            @include('common.error', ['formName' => 'title'])
        </div>
        <div class="d-flex">
            <div class="d-none d-sm-block">
                <div class="align-self-center">
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
                                            {{ $draft->fear }},
                                            {{ $draft->story }},
                                            {{ $draft->volume }},
                                            {{ $draft->graphic }},
                                            {{ $draft->sound }},
                                            {{ $draft->controllability }},
                                            {{ $draft->difficulty }},
                                            {{ $draft->crowded }},
                                            {{ $draft->recommend }}
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

                                $('.value_range').on('input', function (){
                                    let range = $(this);
                                    let idx = parseInt(range.data('index'));
                                    let val = parseInt(range.val());

                                    chart.data.datasets[0].data[idx] = val;
                                    chart.update({
                                        duration: 800,
                                        easing: 'easeOutBounce'
                                    });

                                    $('#' + range.attr('id') + '_value').text(val);

                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-group d-flex">
                <label for="fear" class="col-form-label value_label">怖さ</label>
                <div class="d-flex align-items-stretch">
                    <div class="d-flex justify-content-center">
                        <input type="range"  data-index="0" class="form-control value_range" name="fear" id="fear" value="{{ $draft->fear }}" min="0" max="5">
                    </div>
                    <div class="d-flex justify-content-center review_value_text">
                        <span id="fear_value">{{ $draft->fear }}</span>
                    </div>
                </div>
                </div>
                <div class="form-group d-flex">
                    <label for="story" class="value_label col-form-label">シナリオ</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="1" class="form-control value_range" name="story" id="story" value="{{ $draft->story }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="story_value">{{ $draft->story }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="volume" class="value_label col-form-label">ボリューム</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="2" class="form-control value_range" name="volume" id="volume" value="{{ $draft->volume }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="volume_value">{{ $draft->volume }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="graphic" class="value_label col-form-label">グラフィック</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="3" class="form-control value_range" name="graphic" id="graphic" value="{{ $draft->graphic }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="graphic_value">{{ $draft->graphic }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="sound" class="value_label col-form-label">サウンド</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="4" class="form-control value_range" name="sound" id="sound" value="{{ $draft->sound }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="sound_value">{{ $draft->sound }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="controllability" class="value_label col-form-label">操作性</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="5" class="form-control value_range" name="sound" id="sound" value="{{ $draft->controllability }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="controllability_value">{{ $draft->controllability }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="difficulty" class="value_label col-form-label">難易度</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="6" class="form-control value_range" name="difficulty" id="difficulty" value="{{ $draft->difficulty }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="difficulty_value">{{ $draft->difficulty }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="crowded" class="value_label col-form-label">やりこみ</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="7" class="form-control value_range" name="crowded" id="crowded" value="{{ $draft->crowded }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="crowded_value">{{ $draft->crowded }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="recommend" class="value_label col-form-label">オススメ</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="8" class="form-control value_range" name="recommend" id="recommend" value="{{ $draft->recommend }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="recommend_value">{{ $draft->recommend }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="progress">ゲームのプレイ状況</label>
            <textarea name="progress" id="progress" class="form-control{{ invalid($errors, 'progress') }}" maxlength="300" required>{{ $draft->progress }}</textarea>
            @include('common.error', ['formName' => 'progress'])
            <small class="form-text text-muted">
                「5周クリア」「XXルートだけクリア」など、どの程度遊んだ上でレビューを書くのか記載してください。
            </small>
        </div>

        <div class="form-group">
            <label for="text">レビュー</label>
            <textarea name="text" id="text" class="form-control{{ invalid($errors, 'text') }}" maxlength="10000" required>{{ $draft->text }}</textarea>
            @include('common.error', ['formName' => 'text'])
            <small class="form-text text-muted">
                書き方は自由です！<br>
                良かった点や悪かった点など、思う所を書いていってください。<br>
                <strong><span class="text-danger">ネタバレがある場合は、必ず↓にチェックを入れてください。</span></strong>
            </small>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="is_spoiler"{{ checked(1, $draft->is_spoiler) }} value="1">
                ネタバレあり
            </label>
        </div>

        <br>

        <div class="form-group">
            <button class="btn btn-primary btn-block">確認</button>
        </div>
    </form>

    <script>
        $(function (){
            $('.package_check').on('click', function(){
                $('.package_select_item.selected').removeClass('selected');

                $(this).parents('.package_select_item').addClass('selected');
            });
        });
    </script>


@endsection
