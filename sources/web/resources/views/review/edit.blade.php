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
            @include ('game.common.package_image', ['imageUrl' => $gamePackage->small_image_url])
        </div>
        <div class="align-self-top">
            <div>
                <h4>{{ $gamePackage->name }}のレビュー修正・削除</h4>
            </div>
        </div>
        <div class="align-self-top p-3">
            <form method="POST" onsubmit="return confirm('このレビューを削除します。');">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button class="btn btn-danger">削除</button>
            </form>
        </div>
    </div>

    <hr>

    <form method="POST" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">一言(タイトル)</label>
            <input type="text" name="title" id="title" class="form-control{{ invalid($errors, 'title') }}" value="{{ old('title', $review->title) }}" maxlength="100" required>
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
                            <input type="range"  data-index="0" class="form-control value_range" name="fear" id="fear" value="{{ old('fear', $review->fear) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="fear_value">{{ old('fear', $review->fear) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="story" class="value_label col-form-label">シナリオ</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="1" class="form-control value_range" name="story" id="story" value="{{ old('story', $review->story) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="story_value">{{ old('story', $review->story) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="volume" class="value_label col-form-label">ボリューム</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="2" class="form-control value_range" name="volume" id="volume" value="{{ old('volume', $review->volume) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="volume_value">{{ old('volume', $review->volume) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="graphic" class="value_label col-form-label">グラフィック</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="3" class="form-control value_range" name="graphic" id="graphic" value="{{ old('graphic', $review->graphic) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="graphic_value">{{ old('graphic', $review->graphic) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="sound" class="value_label col-form-label">サウンド</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="4" class="form-control value_range" name="sound" id="sound" value="{{ old('sound', $review->sound) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="sound_value">{{ old('sound', $review->sound) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="controllability" class="value_label col-form-label">操作性</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="5" class="form-control value_range" name="sound" id="sound" value="{{ old('controllability', $review->controllability) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="controllability_value">{{ old('controllability', $review->controllability) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="difficulty" class="value_label col-form-label">難易度</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="6" class="form-control value_range" name="difficulty" id="difficulty" value="{{ old('difficulty', $review->difficulty) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="difficulty_value">{{ old('difficulty', $review->difficulty) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="crowded" class="value_label col-form-label">やりこみ</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="7" class="form-control value_range" name="crowded" id="crowded" value="{{ old('crowded', $review->crowded) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="crowded_value">{{ old('crowded', $review->crowded) }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <label for="recommend" class="value_label col-form-label">オススメ</label>
                    <div class="d-flex align-items-stretch">
                        <div class="d-flex justify-content-center">
                            <input type="range" data-index="8" class="form-control value_range" name="recommend" id="recommend" value="{{ old('recomment', $review->recommend) }}" min="0" max="5">
                        </div>
                        <div class="d-flex justify-content-center review_value_text">
                            <span id="recommend_value">{{ old('recommend', $review->recommend) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="progress">ゲームのプレイ状況</label>
            <textarea name="progress" id="progress" class="form-control{{ invalid($errors, 'progress') }}" maxlength="300" required>{{ old('progress', $review->progress) }}</textarea>
            @include('common.error', ['formName' => 'progress'])
            <small class="form-text text-muted">
                「5周クリア」「XXルートだけクリア」など、どの程度遊んだ上でレビューを書くのか記載してください。
            </small>
        </div>

        <div class="form-group">
            <label for="text">レビュー</label>
            <textarea name="text" id="text" class="form-control{{ invalid($errors, 'text') }}" maxlength="10000" required>{{ old('text', $review->text) }}</textarea>
            @include('common.error', ['formName' => 'text'])
            <small class="form-text text-muted">
                書き方は自由です！<br>
                良かった点や悪かった点など、思う所を書いていってください。<br>
                <strong><span class="text-danger">ネタバレがある場合は、必ず↓にチェックを入れてください。</span></strong>
            </small>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="is_spoiler"{{ checked(1, old('is_spoiler', $review->is_spoiler)) }} value="1">
                ネタバレあり
            </label>
        </div>

        <br>

        <div class="form-group">
            <button class="btn btn-primary btn-block">修正</button>
        </div>
    </form>

@endsection
